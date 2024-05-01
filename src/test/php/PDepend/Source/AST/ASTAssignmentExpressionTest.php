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
 * Test case for the {@link \PDepend\Source\AST\ASTAssignmentExpression} class.
 *
 * @copyright 2008-2017 Manuel Pichler. All rights reserved.
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 *
 * @covers \PDepend\Source\Language\PHP\AbstractPHPParser
 * @covers \PDepend\Source\AST\ASTAssignmentExpression
 * @group unittest
 */
class ASTAssignmentExpressionTest extends ASTNodeTestCase
{
    /**
     * testAssignmentExpressionFromMethodInvocation
     *
     * @return void
     */
    public function testAssignmentExpressionFromMethodInvocation(): void
    {
        $this->assertGraphEquals(
            $this->getFirstAssignmentExpressionInFunction(),
            array(
                'PDepend\\Source\\AST\\ASTVariable',
                'PDepend\\Source\\AST\\ASTMemberPrimaryPrefix',
                'PDepend\\Source\\AST\\ASTVariable',
                'PDepend\\Source\\AST\\ASTMethodPostfix',
                'PDepend\\Source\\AST\\ASTIdentifier',
                'PDepend\\Source\\AST\\ASTArguments'
            )
        );
    }

    /**
     * testAssignmentExpressionFromPropertyAccess
     *
     * @return void
     */
    public function testAssignmentExpressionFromPropertyAccess(): void
    {
        $this->assertGraphEquals(
            $this->getFirstAssignmentExpressionInFunction(),
            array(
                'PDepend\\Source\\AST\\ASTVariable',
                'PDepend\\Source\\AST\\ASTMemberPrimaryPrefix',
                'PDepend\\Source\\AST\\ASTVariable',
                'PDepend\\Source\\AST\\ASTPropertyPostfix',
                'PDepend\\Source\\AST\\ASTIdentifier'
            )
        );
    }

    /**
     * testAssignmentExpressionFromFunctionReturnValue
     *
     * @return void
     */
    public function testAssignmentExpressionFromFunctionReturnValue(): void
    {
        $this->assertGraphEquals(
            $this->getFirstAssignmentExpressionInFunction(),
            array(
                'PDepend\\Source\\AST\\ASTVariable',
                'PDepend\\Source\\AST\\ASTMemberPrimaryPrefix',
                'PDepend\\Source\\AST\\ASTFunctionPostfix',
                'PDepend\\Source\\AST\\ASTIdentifier',
                'PDepend\\Source\\AST\\ASTArguments',
                'PDepend\\Source\\AST\\ASTPropertyPostfix',
                'PDepend\\Source\\AST\\ASTIdentifier'
            )
        );
    }

    /**
     * Tests the resulting object graph.
     *
     * @return void
     */
    public function testAssignmentExpressionGraphForIntegerLiteral(): void
    {
        $this->assertGraphEquals(
            $this->getFirstAssignmentExpressionInFunction(),
            array(
                'PDepend\\Source\\AST\\ASTVariable',
                'PDepend\\Source\\AST\\ASTLiteral'
            )
        );
    }

    /**
     * Tests the resulting object graph.
     *
     * @return void
     */
    public function testAssignmentExpressionGraphForFloatLiteral(): void
    {
        $this->assertGraphEquals(
            $this->getFirstAssignmentExpressionInFunction(),
            array(
                'PDepend\\Source\\AST\\ASTVariable',
                'PDepend\\Source\\AST\\ASTLiteral'
            )
        );
    }

    /**
     * testAssignmentExpressionWithEqual
     *
     * @return void
     * @since 1.0.1
     */
    public function testAssignmentExpressionWithEqual(): void
    {
        $expr = $this->getFirstAssignmentExpressionInFunction();
        $this->assertEquals('=', $expr->getImage());
    }

    /**
     * testAssignmentExpressionWithAndEqual
     *
     * @return void
     * @since 1.0.1
     */
    public function testAssignmentExpressionWithAndEqual(): void
    {
        $expr = $this->getFirstAssignmentExpressionInFunction();
        $this->assertEquals('&=', $expr->getImage());
    }

    /**
     * testAssignmentExpressionWithConcatEqual
     *
     * @return void
     * @since 1.0.1
     */
    public function testAssignmentExpressionWithConcatEqual(): void
    {
        $expr = $this->getFirstAssignmentExpressionInFunction();
        $this->assertEquals('.=', $expr->getImage());
    }

    /**
     * testAssignmentExpressionWithDivEqual
     *
     * @return void
     * @since 1.0.1
     */
    public function testAssignmentExpressionWithDivEqual(): void
    {
        $expr = $this->getFirstAssignmentExpressionInFunction();
        $this->assertEquals('/=', $expr->getImage());
    }

    /**
     * testAssignmentExpressionWithMinusEqual
     *
     * @return void
     * @since 1.0.1
     */
    public function testAssignmentExpressionWithMinusEqual(): void
    {
        $expr = $this->getFirstAssignmentExpressionInFunction();
        $this->assertEquals('-=', $expr->getImage());
    }

    /**
     * testAssignmentExpressionWithModEqual
     *
     * @return void
     * @since 1.0.1
     */
    public function testAssignmentExpressionWithModEqual(): void
    {
        $expr = $this->getFirstAssignmentExpressionInFunction();
        $this->assertEquals('%=', $expr->getImage());
    }

    /**
     * testAssignmentExpressionWithMulEqual
     *
     * @return void
     * @since 1.0.1
     */
    public function testAssignmentExpressionWithMulEqual(): void
    {
        $expr = $this->getFirstAssignmentExpressionInFunction();
        $this->assertEquals('*=', $expr->getImage());
    }

    /**
     * testAssignmentExpressionWithOrEqual
     *
     * @return void
     * @since 1.0.1
     */
    public function testAssignmentExpressionWithOrEqual(): void
    {
        $expr = $this->getFirstAssignmentExpressionInFunction();
        $this->assertEquals('|=', $expr->getImage());
    }

    /**
     * testAssignmentExpressionWithPlusEqual
     *
     * @return void
     * @since 1.0.1
     */
    public function testAssignmentExpressionWithPlusEqual(): void
    {
        $expr = $this->getFirstAssignmentExpressionInFunction();
        $this->assertEquals('+=', $expr->getImage());
    }

    /**
     * testAssignmentExpressionWithXorEqual
     *
     * @return void
     * @since 1.0.1
     */
    public function testAssignmentExpressionWithXorEqual(): void
    {
        $expr = $this->getFirstAssignmentExpressionInFunction();
        $this->assertEquals('^=', $expr->getImage());
    }

    /**
     * testAssignmentExpressionWithShiftLeftEqual
     *
     * @return void
     * @since 1.0.1
     */
    public function testAssignmentExpressionWithShiftLeftEqual(): void
    {
        $expr = $this->getFirstAssignmentExpressionInFunction();
        $this->assertEquals('<<=', $expr->getImage());
    }

    /**
     * testAssignmentExpressionWithShiftRightEqual
     *
     * @return void
     * @since 1.0.1
     */
    public function testAssignmentExpressionWithShiftRightEqual(): void
    {
        $expr = $this->getFirstAssignmentExpressionInFunction();
        $this->assertEquals('>>=', $expr->getImage());
    }

    /**
     * testVariableAssignmentExpression
     *
     * @return \PDepend\Source\AST\ASTAssignmentExpression
     * @since 1.0.1
     */
    public function testVariableAssignmentExpression()
    {
        $expr = $this->getFirstAssignmentExpressionInFunction();
        $this->assertInstanceOf('PDepend\\Source\\AST\\ASTAssignmentExpression', $expr);

        return $expr;
    }

    /**
     * Tests the start line of an assignment-expression.
     *
     * @param \PDepend\Source\AST\ASTAssignmentExpression $expr
     *
     * @return void
     * @depends testVariableAssignmentExpression
     */
    public function testVariableAssignmentExpressionHasExpectedStartLine($expr): void
    {
        $this->assertEquals(4, $expr->getStartLine());
    }

    /**
     * Tests the start column of an assignment-expression.
     *
     * @param \PDepend\Source\AST\ASTAssignmentExpression $expr
     *
     * @return void
     * @depends testVariableAssignmentExpression
     */
    public function testVariableAssignmentExpressionHasExpectedStartColumn($expr): void
    {
        $this->assertEquals(5, $expr->getStartColumn());
    }

    /**
     * Tests the end line of an assignment-expression.
     *
     * @param \PDepend\Source\AST\ASTAssignmentExpression $expr
     *
     * @return void
     * @depends testVariableAssignmentExpression
     */
    public function testVariableAssignmentExpressionHasExpectedEndLine($expr): void
    {
        $this->assertEquals(6, $expr->getEndLine());
    }

    /**
     * Tests the end column of an assignment-expression.
     *
     * @param \PDepend\Source\AST\ASTAssignmentExpression $expr
     *
     * @return void
     * @depends testVariableAssignmentExpression
     */
    public function testVariableAssignmentExpressionHasExpectedEndColumn($expr): void
    {
        $this->assertEquals(5, $expr->getEndColumn());
    }

    /**
     * testStaticPropertyAssignmentExpression
     *
     * @return \PDepend\Source\AST\ASTAssignmentExpression
     * @since 1.0.1
     */
    public function testStaticPropertyAssignmentExpression()
    {
        $expr = $this->getFirstAssignmentExpressionInFunction();
        $this->assertInstanceOf('PDepend\\Source\\AST\\ASTAssignmentExpression', $expr);

        return $expr;
    }

    /**
     * Tests the start line of an assignment-expression.
     *
     * @param \PDepend\Source\AST\ASTAssignmentExpression $expr
     *
     * @return void
     * @depends testStaticPropertyAssignmentExpression
     */
    public function testStaticPropertyAssignmentExpressionHasExpectedStartLine($expr): void
    {
        $this->assertEquals(4, $expr->getStartLine());
    }

    /**
     * Tests the start column of an assignment-expression.
     *
     * @param \PDepend\Source\AST\ASTAssignmentExpression $expr
     *
     * @return void
     * @depends testStaticPropertyAssignmentExpression
     */
    public function testStaticPropertyAssignmentExpressionHasExpectedStartColumn($expr): void
    {
        $this->assertEquals(5, $expr->getStartColumn());
    }

    /**
     * Tests the end line of an assignment-expression.
     *
     * @param \PDepend\Source\AST\ASTAssignmentExpression $expr
     *
     * @return void
     * @depends testStaticPropertyAssignmentExpression
     */
    public function testStaticPropertyAssignmentExpressionHasExpectedEndLine($expr): void
    {
        $this->assertEquals(4, $expr->getEndLine());
    }

    /**
     * Tests the end column of an assignment-expression.
     *
     * @param \PDepend\Source\AST\ASTAssignmentExpression $expr
     *
     * @return void
     * @depends testStaticPropertyAssignmentExpression
     */
    public function testStaticPropertyAssignmentExpressionHasExpectedEndColumn($expr): void
    {
        $this->assertEquals(60, $expr->getEndColumn());
    }

    /**
     * testObjectPropertyAssignmentExpression
     *
     * @return \PDepend\Source\AST\ASTAssignmentExpression
     * @since 1.0.1
     */
    public function testObjectPropertyAssignmentExpression()
    {
        $expr = $this->getFirstAssignmentExpressionInFunction();
        $this->assertInstanceOf('PDepend\\Source\\AST\\ASTAssignmentExpression', $expr);

        return $expr;
    }

    /**
     * Tests the start line of an assignment-expression.
     *
     * @param \PDepend\Source\AST\ASTAssignmentExpression $expr
     *
     * @return void
     * @depends testObjectPropertyAssignmentExpression
     */
    public function testObjectPropertyAssignmentExpressionHasExpectedStartLine($expr): void
    {
        $this->assertEquals(4, $expr->getStartLine());
    }

    /**
     * Tests the start column of an assignment-expression.
     *
     * @param \PDepend\Source\AST\ASTAssignmentExpression $expr
     *
     * @return void
     * @depends testObjectPropertyAssignmentExpression
     */
    public function testObjectPropertyAssignmentExpressionHasExpectedStartColumn($expr): void
    {
        $this->assertEquals(5, $expr->getStartColumn());
    }

    /**
     * Tests the end line of an assignment-expression.
     *
     * @param \PDepend\Source\AST\ASTAssignmentExpression $expr
     *
     * @return void
     * @depends testObjectPropertyAssignmentExpression
     */
    public function testObjectPropertyAssignmentExpressionHasExpectedEndLine($expr): void
    {
        $this->assertEquals(5, $expr->getEndLine());
    }

    /**
     * Tests the end column of an assignment-expression.
     *
     * @param \PDepend\Source\AST\ASTAssignmentExpression $expr
     *
     * @return void
     * @depends testObjectPropertyAssignmentExpression
     */
    public function testObjectPropertyAssignmentExpressionHasExpectedEndColumn($expr): void
    {
        $this->assertEquals(15, $expr->getEndColumn());
    }

    /**
     * testChainedPropertyAssignmentExpression
     *
     * @return \PDepend\Source\AST\ASTAssignmentExpression
     * @since 1.0.1
     */
    public function testChainedPropertyAssignmentExpression()
    {
        $expr = $this->getFirstAssignmentExpressionInFunction();
        $this->assertInstanceOf('PDepend\\Source\\AST\\ASTAssignmentExpression', $expr);

        return $expr;
    }

    /**
     * Tests the start line of an assignment-expression.
     *
     * @param \PDepend\Source\AST\ASTAssignmentExpression $expr
     *
     * @return void
     * @depends testChainedPropertyAssignmentExpression
     */
    public function testChainedPropertyAssignmentExpressionHasExpectedStartLine($expr): void
    {
        $this->assertEquals(4, $expr->getStartLine());
    }

    /**
     * Tests the start column of an assignment-expression.
     *
     * @param \PDepend\Source\AST\ASTAssignmentExpression $expr
     *
     * @return void
     * @depends testChainedPropertyAssignmentExpression
     */
    public function testChainedPropertyAssignmentExpressionHasExpectedStartColumn($expr): void
    {
        $this->assertEquals(5, $expr->getStartColumn());
    }

    /**
     * Tests the end column of an assignment-expression.
     *
     * @param \PDepend\Source\AST\ASTAssignmentExpression $expr
     *
     * @return void
     * @depends testChainedPropertyAssignmentExpression
     */
    public function testChainedPropertyAssignmentExpressionHasExpectedEndColumn($expr): void
    {
        $this->assertEquals(23, $expr->getEndColumn());
    }

    /**
     * Tests the end line of an assignment-expression.
     *
     * @param \PDepend\Source\AST\ASTAssignmentExpression $expr
     *
     * @return void
     * @depends testChainedPropertyAssignmentExpression
     */
    public function testChainedPropertyAssignmentExpressionHasExpectedEndLine($expr): void
    {
        $this->assertEquals(8, $expr->getEndLine());
    }

    /**
     * Returns a test assignment-expression.
     *
     * @return \PDepend\Source\AST\ASTAssignmentExpression
     */
    private function getFirstAssignmentExpressionInFunction()
    {
        return $this->getFirstNodeOfTypeInFunction(
            $this->getCallingTestMethod(),
            'PDepend\\Source\\AST\\ASTAssignmentExpression'
        );
    }
}
