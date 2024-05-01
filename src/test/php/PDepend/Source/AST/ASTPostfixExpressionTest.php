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
 * Test case for the {@link ASTPostfixExpression} class.
 *
 * @copyright 2008-2017 Manuel Pichler. All rights reserved.
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 *
 * @covers \PDepend\Source\Language\PHP\AbstractPHPParser
 * @covers \PDepend\Source\AST\ASTPostfixExpression
 * @group unittest
 */
class ASTPostfixExpressionTest extends ASTNodeTestCase
{
    /**
     * testIncrementPostfixExpressionOnStaticClassMember
     *
     * @return void
     */
    public function testIncrementPostfixExpressionOnStaticClassMember(): void
    {
        $expr = $this->getFirstPostfixExpressionInClass(__METHOD__);
        $this->assertGraphEquals(
            $expr,
            array(
                'PDepend\\Source\\AST\\ASTMemberPrimaryPrefix',
                'PDepend\\Source\\AST\\ASTClassOrInterfaceReference',
                'PDepend\\Source\\AST\\ASTPropertyPostfix',
                'PDepend\\Source\\AST\\ASTVariable'
            )
        );
    }

    /**
     * testIncrementPostfixExpressionOnSelfClassMember
     *
     * @return void
     */
    public function testIncrementPostfixExpressionOnSelfClassMember(): void
    {
        $expr = $this->getFirstPostfixExpressionInClass(__METHOD__);
        $this->assertGraphEquals(
            $expr,
            array(
                'PDepend\\Source\\AST\\ASTMemberPrimaryPrefix',
                'PDepend\\Source\\AST\\ASTSelfReference',
                'PDepend\\Source\\AST\\ASTPropertyPostfix',
                'PDepend\\Source\\AST\\ASTVariable'
            )
        );
    }

    /**
     * testIncrementPostfixExpressionOnParentClassMember
     *
     * @return void
     */
    public function testIncrementPostfixExpressionOnParentClassMember(): void
    {
        $expr = $this->getFirstPostfixExpressionInClass(__METHOD__);
        $this->assertGraphEquals(
            $expr,
            array(
                'PDepend\\Source\\AST\\ASTMemberPrimaryPrefix',
                'PDepend\\Source\\AST\\ASTParentReference',
                'PDepend\\Source\\AST\\ASTPropertyPostfix',
                'PDepend\\Source\\AST\\ASTVariable'
            )
        );
    }

    /**
     * testIncrementPostfixExpressionOnThisObjectMember
     *
     * @return void
     */
    public function testIncrementPostfixExpressionOnThisObjectMember(): void
    {
        $expr = $this->getFirstPostfixExpressionInClass(__METHOD__);
        $this->assertGraphEquals(
            $expr,
            array(
                'PDepend\\Source\\AST\\ASTMemberPrimaryPrefix',
                'PDepend\\Source\\AST\\ASTVariable',
                'PDepend\\Source\\AST\\ASTPropertyPostfix',
                'PDepend\\Source\\AST\\ASTIdentifier'
            )
        );
    }

    /**
     * testIncrementPostfixExpressionOnFunctionPostfix
     *
     * @return void
     */
    public function testIncrementPostfixExpressionOnFunctionPostfix(): void
    {
        $expr = $this->getFirstPostfixExpressionInFunction(__METHOD__);
        $this->assertGraphEquals(
            $expr,
            array(
                'PDepend\\Source\\AST\\ASTFunctionPostfix',
                'PDepend\\Source\\AST\\ASTIdentifier',
                'PDepend\\Source\\AST\\ASTArguments',
                'PDepend\\Source\\AST\\ASTVariable'
            )
        );
    }

    /**
     * testIncrementPostfixExpressionOnVariableVariable
     *
     * @return void
     */
    public function testIncrementPostfixExpressionOnVariableVariable(): void
    {
        $expr = $this->getFirstPostfixExpressionInFunction(__METHOD__);
        $this->assertGraphEquals(
            $expr,
            array(
                'PDepend\\Source\\AST\\ASTVariableVariable',
                'PDepend\\Source\\AST\\ASTVariableVariable',
                'PDepend\\Source\\AST\\ASTVariable'
            )
        );
    }

    /**
     * testIncrementPostfixExpressionOnCompoundVariable
     *
     * @return void
     */
    public function testIncrementPostfixExpressionOnCompoundVariable(): void
    {
        $expr = $this->getFirstPostfixExpressionInFunction(__METHOD__);
        $this->assertGraphEquals(
            $expr,
            array(
                'PDepend\\Source\\AST\\ASTCompoundVariable',
                'PDepend\\Source\\AST\\ASTConstant'
            )
        );
    }

    /**
     * testIncrementPostfixExpressionOnObjectMethodPostfix
     *
     * @return void
     */
    public function testIncrementPostfixExpressionOnObjectMethodPostfix(): void
    {
        $expr = $this->getFirstPostfixExpressionInFunction(__METHOD__);
        $this->assertGraphEquals(
            $expr,
            array(
                'PDepend\\Source\\AST\\ASTMemberPrimaryPrefix',
                'PDepend\\Source\\AST\\ASTVariable',
                'PDepend\\Source\\AST\\ASTMethodPostfix',
                'PDepend\\Source\\AST\\ASTIdentifier',
                'PDepend\\Source\\AST\\ASTArguments',
                'PDepend\\Source\\AST\\ASTVariable'
            )
        );
    }

    /**
     * testIncrementPostfixExpressionOnStaticMethodPostfix
     *
     * @return void
     */
    public function testIncrementPostfixExpressionOnStaticMethodPostfix(): void
    {
        $expr = $this->getFirstPostfixExpressionInFunction(__METHOD__);
        $this->assertGraphEquals(
            $expr,
            array(
                'PDepend\\Source\\AST\\ASTMemberPrimaryPrefix',
                'PDepend\\Source\\AST\\ASTClassOrInterfaceReference',
                'PDepend\\Source\\AST\\ASTMethodPostfix',
                'PDepend\\Source\\AST\\ASTIdentifier',
                'PDepend\\Source\\AST\\ASTArguments'
            )
        );
    }

    /**
     * testIncrementPostfixExpressionArrayPropertyPostfix
     *
     * @return void
     */
    public function testIncrementPostfixExpressionArrayPropertyPostfix(): void
    {
        $expr = $this->getFirstPostfixExpressionInClass(__METHOD__)->getParent();
        $this->assertGraphEquals(
            $expr,
            array(
                'PDepend\\Source\\AST\\ASTPostfixExpression',
                'PDepend\\Source\\AST\\ASTMemberPrimaryPrefix',
                'PDepend\\Source\\AST\\ASTVariable',
                'PDepend\\Source\\AST\\ASTPropertyPostfix',
                'PDepend\\Source\\AST\\ASTArrayIndexExpression',
                'PDepend\\Source\\AST\\ASTIdentifier',
                'PDepend\\Source\\AST\\ASTVariable'
            )
        );
    }
    
    /**
     * testIncrementPostfixExpressionHasExpectedStartLine
     *
     * @return void
     */
    public function testIncrementPostfixExpressionHasExpectedStartLine(): void
    {
        $expr = $this->getFirstPostfixExpressionInFunction(__METHOD__);
        $this->assertEquals(5, $expr->getStartLine());
    }

    /**
     * testIncrementPostfixExpressionHasExpectedStartColumn
     *
     * @return void
     */
    public function testIncrementPostfixExpressionHasExpectedStartColumn(): void
    {
        $expr = $this->getFirstPostfixExpressionInFunction(__METHOD__);
        $this->assertEquals(9, $expr->getStartColumn());
    }

    /**
     * testIncrementPostfixExpressionHasExpectedEndLine
     *
     * @return void
     */
    public function testIncrementPostfixExpressionHasExpectedEndLine(): void
    {
        $expr = $this->getFirstPostfixExpressionInFunction(__METHOD__);
        $this->assertEquals(7, $expr->getEndLine());
    }

    /**
     * testIncrementPostfixExpressionHasExpectedEndColumn
     *
     * @return void
     */
    public function testIncrementPostfixExpressionHasExpectedEndColumn(): void
    {
        $expr = $this->getFirstPostfixExpressionInFunction(__METHOD__);
        $this->assertEquals(14, $expr->getEndColumn());
    }

    /**
     * testDecrementPostfixExpressionArrayPropertyPostfix
     *
     * @return void
     */
    public function testDecrementPostfixExpressionArrayPropertyPostfix(): void
    {
        $expr = $this->getFirstPostfixExpressionInClass(__METHOD__)->getParent();
        $this->assertGraphEquals(
            $expr,
            array(
                'PDepend\\Source\\AST\\ASTPostfixExpression',
                'PDepend\\Source\\AST\\ASTMemberPrimaryPrefix',
                'PDepend\\Source\\AST\\ASTVariable',
                'PDepend\\Source\\AST\\ASTPropertyPostfix',
                'PDepend\\Source\\AST\\ASTArrayIndexExpression',
                'PDepend\\Source\\AST\\ASTIdentifier',
                'PDepend\\Source\\AST\\ASTVariable'
            )
        );
    }
    
    /**
     * testDecrementPostfixExpressionHasExpectedStartLine
     *
     * @return void
     */
    public function testDecrementPostfixExpressionHasExpectedStartLine(): void
    {
        $expr = $this->getFirstPostfixExpressionInFunction(__METHOD__);
        $this->assertEquals(7, $expr->getStartLine());
    }

    /**
     * testDecrementPostfixExpressionHasExpectedStartColumn
     *
     * @return void
     */
    public function testDecrementPostfixExpressionHasExpectedStartColumn(): void
    {
        $expr = $this->getFirstPostfixExpressionInFunction(__METHOD__);
        $this->assertEquals(17, $expr->getStartColumn());
    }

    /**
     * testDecrementPostfixExpressionHasExpectedEndLine
     *
     * @return void
     */
    public function testDecrementPostfixExpressionHasExpectedEndLine(): void
    {
        $expr = $this->getFirstPostfixExpressionInFunction(__METHOD__);
        $this->assertEquals(9, $expr->getEndLine());
    }

    /**
     * testDecrementPostfixExpressionHasExpectedEndColumn
     *
     * @return void
     */
    public function testDecrementPostfixExpressionHasExpectedEndColumn(): void
    {
        $expr = $this->getFirstPostfixExpressionInFunction(__METHOD__);
        $this->assertEquals(10, $expr->getEndColumn());
    }

    /**
     * Returns a node instance for the currently executed test case.
     *
     * @param string $testCase Name of the calling test case.
     *
     * @return ASTPostfixExpression
     */
    private function getFirstPostfixExpressionInClass($testCase)
    {
        return $this->getFirstNodeOfTypeInClass(
            $testCase,
            'PDepend\\Source\\AST\\ASTPostfixExpression'
        );
    }

    /**
     * Returns a node instance for the currently executed test case.
     *
     * @param string $testCase Name of the calling test case.
     *
     * @return ASTPostfixExpression
     */
    private function getFirstPostfixExpressionInFunction($testCase)
    {
        return $this->getFirstNodeOfTypeInFunction(
            $testCase,
            'PDepend\\Source\\AST\\ASTPostfixExpression'
        );
    }
}
