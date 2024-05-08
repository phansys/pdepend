<?php
/**
 * This file is part of PDepend.
 *
 * PHP Version 5
 *
 * Copyright (c) 2008-2017 Manuel Pichler <mapi@pdepend.org>.
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
 * @copyright 2008-2017 Manuel Pichler. All rights reserved.
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 */

namespace PDepend\Source\AST;

/**
 * Test case for the {@link \PDepend\Source\AST\ASTTryStatement} class.
 *
 * @covers \PDepend\Source\Language\PHP\AbstractPHPParser
 * @covers \PDepend\Source\AST\ASTTryStatement
 * @copyright 2008-2017 Manuel Pichler. All rights reserved.
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 *
 * @group unittest
 */
class ASTTryStatementTest extends ASTNodeTestCase
{
    /**
     * testTryStatement
     *
     * @return ASTTryStatement
     * @since 1.0.2
     */
    public function testTryStatement()
    {
        $stmt = $this->getFirstTryStatementInFunction();
        $this->assertInstanceOf('PDepend\\Source\\AST\\ASTTryStatement', $stmt);

        return $stmt;
    }

    /**
     * Tests that the try-statement has the expected start line value.
     *
     * @param ASTTryStatement $stmt
     *
     * @depends testTryStatement
     */
    public function testTryStatementHasExpectedStartLine($stmt): void
    {
        $this->assertEquals(4, $stmt->getStartLine());
    }

    /**
     * Tests that the try-statement has the expected start column value.
     *
     * @param ASTTryStatement $stmt
     *
     * @depends testTryStatement
     */
    public function testTryStatementHasExpectedStartColumn($stmt): void
    {
        $this->assertEquals(5, $stmt->getStartColumn());
    }

    /**
     * Tests that the try-statement has the expected end line value.
     *
     * @param ASTTryStatement $stmt
     *
     * @depends testTryStatement
     */
    public function testTryStatementHasExpectedEndLine($stmt): void
    {
        $this->assertEquals(8, $stmt->getEndLine());
    }

    /**
     * Tests that the try-statement has the expected end column value.
     *
     * @param ASTTryStatement $stmt
     *
     * @depends testTryStatement
     */
    public function testTryStatementHasExpectedEndColumn($stmt): void
    {
        $this->assertEquals(5, $stmt->getEndColumn());
    }

    /**
     * testFirstChildOfTryStatementIsInstanceOfScopeStatement
     *
     * @param ASTTryStatement $stmt
     *
     * @depends testTryStatement
     */
    public function testFirstChildOfTryStatementIsInstanceOfScopeStatement($stmt): void
    {
        $this->assertInstanceOf('PDepend\\Source\\AST\\ASTScopeStatement', $stmt->getChild(0));
    }

    /**
     * testSecondChildOfTryStatementIsInstanceOfCatchStatement
     *
     * @param ASTTryStatement $stmt
     *
     * @depends testTryStatement
     */
    public function testSecondChildOfTryStatementIsInstanceOfCatchStatement($stmt): void
    {
        $this->assertInstanceOf('PDepend\\Source\\AST\\ASTCatchStatement', $stmt->getChild(1));
    }

    /**
     * testTryStatementContainsMultipleChildInstancesOfCatchStatement
     */
    public function testTryStatementContainsMultipleChildInstancesOfCatchStatement(): void
    {
        $actual = [];
        foreach ($this->getFirstTryStatementInFunction(__METHOD__)->getChildren() as $child) {
            $actual[] = $child::class;
        }

        $expected = [
            'PDepend\\Source\\AST\\ASTScopeStatement',
            'PDepend\\Source\\AST\\ASTCatchStatement',
            'PDepend\\Source\\AST\\ASTCatchStatement',
            'PDepend\\Source\\AST\\ASTCatchStatement',
            'PDepend\\Source\\AST\\ASTCatchStatement',
        ];

        $this->assertEquals($expected, $actual);
    }

    /**
     * testParserThrowsExceptionWhenNoCatchStatementFollows
     */
    public function testParserThrowsExceptionWhenNoCatchStatementFollows(): void
    {
        $this->expectException(\PDepend\Source\Parser\UnexpectedTokenException::class);

        $this->getFirstTryStatementInFunction();
    }

    /**
     * Returns a node instance for the currently executed test case.
     *
     * @return ASTTryStatement
     */
    private function getFirstTryStatementInFunction()
    {
        return $this->getFirstNodeOfTypeInFunction(
            $this->getCallingTestMethod(),
            'PDepend\\Source\\AST\\ASTTryStatement'
        );
    }
}
