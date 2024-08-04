<?php

/**
 * This file is part of PDepend.
 *
 * PHP Version 5
 *
 * Copyright (c) 2015 Matthias Mullie <pdepend@mullie.eu>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Manuel Pichler nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @copyright 2015 Matthias Mullie. All rights reserved.
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 */

namespace PDepend\Metrics\Analyzer;

use PDepend\Metrics\AbstractMetricsTestCase;
use PDepend\Source\AST\ASTArtifact;
use PDepend\Util\Cache\CacheDriver;
use PDepend\Util\Cache\Driver\MemoryCacheDriver;

/**
 * Test case for the cyclomatic analyzer.
 *
 * @covers \PDepend\Metrics\AbstractCachingAnalyzer
 * @covers \PDepend\Metrics\Analyzer\HalsteadAnalyzer
 * @copyright 2015 Matthias Mullie. All rights reserved.
 * @license http://www.opensource.org/licenses/bsd-license.php  BSD License
 *
 * @group unittest
 */
class HalsteadAnalyzerTest extends AbstractMetricsTestCase
{
    /** @since 1.0.0 */
    private CacheDriver $cache;

    /**
     * Initializes a in memory cache.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->cache = new MemoryCacheDriver();
    }

    /**
     * testGetNodeMetricsReturnsNothingForUnknownNode
     */
    public function testGetNodeMetricsReturnsNothingForUnknownNode(): void
    {
        $analyzer = $this->createAnalyzer();
        $astArtifact = $this->getMockBuilder(ASTArtifact::class)
            ->getMock();
        static::assertEquals([], $analyzer->getNodeMetrics($astArtifact));
    }

    /**
     * Tests that the analyzer calculates the correct function Halstead n1, n2,
     * N1 & N2.
     */
    public function testCalculateFunctionBaseMeasures(): void
    {
        $namespaces = $this->parseCodeResourceForTest();

        $analyzer = $this->createAnalyzer();
        $analyzer->analyze($namespaces);

        $actual = [];
        $expected = [
            'pdepend1' => ['n1' => 5, 'n2' => 3, 'N1' => 6, 'N2' => 4],
            'pdepend2' => ['n1' => 4, 'n2' => 2, 'N1' => 4, 'N2' => 2],
        ];

        foreach ($namespaces[0]->getFunctions() as $function) {
            $actual[$function->getImage()] = $analyzer->getNodeBasisMetrics($function);
        }

        ksort($expected);
        ksort($actual);

        static::assertEquals($expected, $actual);
    }

    /**
     * Tests that the analyzer calculates the correct function Halstead n1, n2,
     * N1 & N2.
     */
    public function testCalculateFunctionMeasures(): void
    {
        $namespaces = $this->parseCodeResourceForTest();

        $analyzer = $this->createAnalyzer();
        $analyzer->analyze($namespaces);

        $actual = [];
        $expected = [
            'pdepend1' => [
                'hnt' => 10,
                'hnd' => 8,
                'hv' => 30.0,
                'hd' => 5.0,
                'hl' => 0.2,
                'he' => 150.0,
                'ht' => 8.333333333333334,
                'hb' => 0.009410360288810284,
                'hi' => 6.0,
            ],
            'pdepend2' => [
                'hnt' => 6,
                'hnd' => 6,
                'hv' => 15.509775004327,
                'hd' => 4,
                'hl' => 0.25,
                'he' => 62.039100017308,
                'ht' => 3.4466166676282,
                'hb' => 0.0052238304343202,
                'hi' => 3.8774437510817,
            ],
        ];

        foreach ($namespaces[0]->getFunctions() as $function) {
            $actual[$function->getImage()] = $analyzer->getNodeMetrics($function);
        }

        ksort($expected);
        ksort($actual);

        static::assertEqualsWithDelta($expected, $actual, 0.01);
    }

    /**
     * Tests that the analyzer calculates the correct method Halstead n1, n2,
     * N1 & N2.
     */
    public function testCalculateMethodBaseMeasures(): void
    {
        $namespaces = $this->parseCodeResourceForTest();

        $analyzer = $this->createAnalyzer();
        $analyzer->analyze($namespaces);

        $classes = $namespaces[0]->getClasses();
        $methods = $classes[0]->getMethods();

        $actual = [];
        $expected = [
            'pdepend1' => ['n1' => 5, 'n2' => 3, 'N1' => 6, 'N2' => 4],
            'pdepend2' => ['n1' => 4, 'n2' => 2, 'N1' => 4, 'N2' => 2],
        ];

        foreach ($methods as $method) {
            $actual[$method->getImage()] = $analyzer->getNodeBasisMetrics($method);
        }

        ksort($expected);
        ksort($actual);

        static::assertEquals($expected, $actual);
    }

    /**
     * Tests that the analyzer calculates the correct method Halstead n1, n2,
     * N1 & N2.
     */
    public function testCalculateMethodMeasures(): void
    {
        $namespaces = $this->parseCodeResourceForTest();

        $analyzer = $this->createAnalyzer();
        $analyzer->analyze($namespaces);

        $classes = $namespaces[0]->getClasses();
        $methods = $classes[0]->getMethods();

        $actual = [];
        $expected = [
            'pdepend1' => [
                'hnt' => 10,
                'hnd' => 8,
                'hv' => 30.0,
                'hd' => 5.0,
                'hl' => 0.2,
                'he' => 150.0,
                'ht' => 8.333333333333334,
                'hb' => 0.009410360288810284,
                'hi' => 6.0,
            ],
            'pdepend2' => [
                'hnt' => 6,
                'hnd' => 6,
                'hv' => 15.509775004327,
                'hd' => 4,
                'hl' => 0.25,
                'he' => 62.039100017308,
                'ht' => 3.4466166676282,
                'hb' => 0.0052238304343202,
                'hi' => 3.8774437510817,
            ],
        ];

        foreach ($methods as $method) {
            $actual[$method->getImage()] = $analyzer->getNodeMetrics($method);
        }

        ksort($expected);
        ksort($actual);

        static::assertEqualsWithDelta($expected, $actual, 0.01);
    }

    /**
     * testAnalyzerRestoresExpectedFunctionMetricsFromCache
     *
     * @since 1.0.0
     */
    public function testAnalyzerRestoresExpectedFunctionMetricsFromCache(): void
    {
        $namespaces = $this->parseCodeResourceForTest();
        $functions = $namespaces[0]->getFunctions();

        $analyzer = $this->createAnalyzer();
        $analyzer->analyze($namespaces);

        $metrics0 = $analyzer->getNodeMetrics($functions[0]);

        $analyzer = $this->createAnalyzer();
        $analyzer->analyze($namespaces);

        $metrics1 = $analyzer->getNodeMetrics($functions[0]);

        static::assertEquals($metrics0, $metrics1);
    }

    /**
     * testAnalyzerRestoresExpectedMethodMetricsFromCache
     *
     * @since 1.0.0
     */
    public function testAnalyzerRestoresExpectedMethodMetricsFromCache(): void
    {
        $namespaces = $this->parseCodeResourceForTest();
        $classes = $namespaces[0]->getClasses();
        $methods = $classes[0]->getMethods();

        $analyzer = $this->createAnalyzer();
        $analyzer->analyze($namespaces);

        $metrics0 = $analyzer->getNodeMetrics($methods[0]);

        $analyzer = $this->createAnalyzer();
        $analyzer->analyze($namespaces);

        $metrics1 = $analyzer->getNodeMetrics($methods[0]);

        static::assertEquals($metrics0, $metrics1);
    }

    /**
     * Returns a pre configured ccn analyzer.
     *
     * @since 1.0.0
     */
    private function createAnalyzer(): HalsteadAnalyzer
    {
        $analyzer = new HalsteadAnalyzer();
        $analyzer->setCache($this->cache);

        return $analyzer;
    }
}