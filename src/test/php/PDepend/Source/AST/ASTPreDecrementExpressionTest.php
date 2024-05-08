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
 * Test case for the {@link \PDepend\Source\AST\ASTPreDecrementExpression} class.
 *
 * @covers \PDepend\Source\Language\PHP\AbstractPHPParser
 * @covers \PDepend\Source\AST\ASTPreDecrementExpression
 * @copyright 2008-2017 Manuel Pichler. All rights reserved.
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 *
 * @group unittest
 */
class ASTPreDecrementExpressionTest extends ASTNodeTestCase
{
    /**
     * testPreDecrementExpressionOnStaticClassMember
     */
    public function testPreDecrementExpressionOnStaticClassMember(): void
    {
        $expr = $this->getFirstPreDecrementExpressionInFunction(__METHOD__);
        $this->assertGraphEquals(
            $expr,
            [
                'PDepend\\Source\\AST\\ASTMemberPrimaryPrefix',
                'PDepend\\Source\\AST\\ASTClassOrInterfaceReference',
                'PDepend\\Source\\AST\\ASTPropertyPostfix',
                'PDepend\\Source\\AST\\ASTVariable',
            ]
        );
    }

    /**
     * testPreDecrementExpressionOnSelfClassMember
     */
    public function testPreDecrementExpressionOnSelfClassMember(): void
    {
        $expr = $this->getFirstPreDecrementExpressionInClass(__METHOD__);
        $this->assertGraphEquals(
            $expr,
            [
                'PDepend\\Source\\AST\\ASTMemberPrimaryPrefix',
                'PDepend\\Source\\AST\\ASTSelfReference',
                'PDepend\\Source\\AST\\ASTPropertyPostfix',
                'PDepend\\Source\\AST\\ASTVariable',
            ]
        );
    }

    /**
     * testPreDecrementExpressionOnParentClassMember
     */
    public function testPreDecrementExpressionOnParentClassMember(): void
    {
        $expr = $this->getFirstPreDecrementExpressionInClass(__METHOD__);
        $this->assertGraphEquals(
            $expr,
            [
                'PDepend\\Source\\AST\\ASTMemberPrimaryPrefix',
                'PDepend\\Source\\AST\\ASTParentReference',
                'PDepend\\Source\\AST\\ASTPropertyPostfix',
                'PDepend\\Source\\AST\\ASTVariable',
            ]
        );
    }

    /**
     * testPreDecrementExpressionOnFunctionPostfix
     */
    public function testPreDecrementExpressionOnFunctionPostfix(): void
    {
        $expr = $this->getFirstPreDecrementExpressionInFunction(__METHOD__);
        $this->assertGraphEquals(
            $expr,
            [
                'PDepend\\Source\\AST\\ASTFunctionPostfix',
                'PDepend\\Source\\AST\\ASTIdentifier',
                'PDepend\\Source\\AST\\ASTArguments',
            ]
        );
    }

    /**
     * testPreDecrementExpressionOnStaticVariableMember
     */
    public function testPreDecrementExpressionOnStaticVariableMember(): void
    {
        $expr = $this->getFirstPreDecrementExpressionInFunction(__METHOD__);
        $this->assertGraphEquals(
            $expr,
            [
                'PDepend\\Source\\AST\\ASTMemberPrimaryPrefix',
                'PDepend\\Source\\AST\\ASTVariable',
                'PDepend\\Source\\AST\\ASTPropertyPostfix',
                'PDepend\\Source\\AST\\ASTVariable',
            ]
        );
    }

    /**
     * testPreDecrementExpressionHasExpectedStartLine
     */
    public function testPreDecrementExpressionHasExpectedStartLine(): void
    {
        $expr = $this->getFirstPreDecrementExpressionInFunction(__METHOD__);
        $this->assertEquals(4, $expr->getStartLine());
    }

    /**
     * testPreDecrementExpressionHasExpectedStartColumn
     */
    public function testPreDecrementExpressionHasExpectedStartColumn(): void
    {
        $expr = $this->getFirstPreDecrementExpressionInFunction(__METHOD__);
        $this->assertEquals(12, $expr->getStartColumn());
    }

    /**
     * testPreDecrementExpressionHasExpectedEndLine
     */
    public function testPreDecrementExpressionHasExpectedEndLine(): void
    {
        $expr = $this->getFirstPreDecrementExpressionInFunction(__METHOD__);
        $this->assertEquals(7, $expr->getEndLine());
    }

    /**
     * testPreDecrementExpressionHasExpectedEndColumn
     */
    public function testPreDecrementExpressionHasExpectedEndColumn(): void
    {
        $expr = $this->getFirstPreDecrementExpressionInFunction(__METHOD__);
        $this->assertEquals(21, $expr->getEndColumn());
    }

    /**
     * Returns a node instance for the currently executed test case.
     *
     * @param string $testCase Name of the calling test case.
     * @return ASTPreDecrementExpression
     */
    private function getFirstPreDecrementExpressionInClass($testCase)
    {
        return $this->getFirstNodeOfTypeInClass(
            $testCase,
            'PDepend\\Source\\AST\\ASTPreDecrementExpression'
        );
    }

    /**
     * Returns a node instance for the currently executed test case.
     *
     * @param string $testCase Name of the calling test case.
     * @return ASTPreDecrementExpression
     */
    private function getFirstPreDecrementExpressionInFunction($testCase)
    {
        return $this->getFirstNodeOfTypeInFunction(
            $testCase,
            'PDepend\\Source\\AST\\ASTPreDecrementExpression'
        );
    }
}
