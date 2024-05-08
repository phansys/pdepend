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
 * Test case for the {@link \PDepend\Source\AST\ASTPropertyPostfix} class.
 *
 * @covers \PDepend\Source\Language\PHP\AbstractPHPParser
 * @covers \PDepend\Source\Language\PHP\PHPBuilder
 * @covers \PDepend\Source\AST\ASTPropertyPostfix
 *
 * @group unittest
 *
 * @covers \PDepend\Source\Language\PHP\AbstractPHPParser
 * @covers \PDepend\Source\AST\ASTPropertyPostfix
 * @copyright 2008-2017 Manuel Pichler. All rights reserved.
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 */
class ASTPropertyPostfixTest extends ASTNodeTestCase
{
    /**
     * testGetImageForArrayIndexedRegularProperty
     */
    public function testGetImageForArrayIndexedRegularProperty(): void
    {
        $postfix = $this->getFirstPropertyPostfixInFunction();
        $this->assertEquals('property', $postfix->getImage());
    }

    /**
     * testGetImageForMultiDimensionalArrayIndexedRegularProperty
     */
    public function testGetImageForMultiDimensionalArrayIndexedRegularProperty(): void
    {
        $postfix = $this->getFirstPropertyPostfixInFunction();
        $this->assertEquals('property', $postfix->getImage());
    }

    /**
     * testGetImageForVariableProperty
     */
    public function testGetImageForVariableProperty(): void
    {
        $postfix = $this->getFirstPropertyPostfixInFunction();
        $this->assertEquals('$property', $postfix->getImage());
    }

    /**
     * testGetImageForArrayIndexedVariableProperty
     */
    public function testGetImageForArrayIndexedVariableProperty(): void
    {
        $postfix = $this->getFirstPropertyPostfixInFunction();
        $this->assertEquals('$property', $postfix->getImage());
    }

    /**
     * testPropertyPostfixGraphForArrayElementInvocation
     *
     * <code>
     * $this->$foo[0];
     * </code>
     */
    public function testPropertyPostfixGraphForArrayElementInvocation(): void
    {
        $prefix = $this->getFirstMemberPrimaryPrefixInClass(__METHOD__);
        $expected = [
            'PDepend\\Source\\AST\\ASTVariable',
            'PDepend\\Source\\AST\\ASTPropertyPostfix',
            'PDepend\\Source\\AST\\ASTArrayIndexExpression',
            'PDepend\\Source\\AST\\ASTVariable',
            'PDepend\\Source\\AST\\ASTLiteral',
        ];

        $this->assertGraphEquals($prefix, $expected);
    }

    /**
     * testPropertyPostfixGraphForPropertyArrayElementInvocation
     *
     * <code>
     * $this->foo[$bar]();
     * </code>
     */
    public function testPropertyPostfixGraphForPropertyArrayElementInvocation(): void
    {
        $prefix = $this->getFirstMemberPrimaryPrefixInClass(__METHOD__);
        $expected = [
            'PDepend\\Source\\AST\\ASTVariable',
            'PDepend\\Source\\AST\\ASTPropertyPostfix',
            'PDepend\\Source\\AST\\ASTArrayIndexExpression',
            'PDepend\\Source\\AST\\ASTIdentifier',
            'PDepend\\Source\\AST\\ASTVariable',
        ];

        $this->assertGraphEquals($prefix, $expected);
    }

    /**
     * Tests that a parsed property postfix has the expected object structure.
     */
    public function testPropertyPostfixStructureForSimpleIdentifierAccess(): void
    {
        $prefix = $this->getFirstMemberPrimaryPrefixInFunction(__METHOD__);
        $expected = [
            'PDepend\\Source\\AST\\ASTVariable',
            'PDepend\\Source\\AST\\ASTPropertyPostfix',
            'PDepend\\Source\\AST\\ASTIdentifier',
        ];

        $this->assertGraphEquals($prefix, $expected);
    }

    /**
     * Tests that a parsed property postfix has the expected object structure.
     */
    public function testPropertyPostfixStructureForVariableAccess(): void
    {
        $prefix = $this->getFirstMemberPrimaryPrefixInFunction(__METHOD__);
        $expected = [
            'PDepend\\Source\\AST\\ASTVariable',
            'PDepend\\Source\\AST\\ASTPropertyPostfix',
            'PDepend\\Source\\AST\\ASTVariable',
        ];

        $this->assertGraphEquals($prefix, $expected);
    }

    /**
     * Tests that a parsed property postfix has the expected object structure.
     */
    public function testPropertyPostfixStructureForVariableVariableAccess(): void
    {
        $prefix = $this->getFirstMemberPrimaryPrefixInFunction(__METHOD__);
        $expected = [
            'PDepend\\Source\\AST\\ASTVariable',
            'PDepend\\Source\\AST\\ASTPropertyPostfix',
            'PDepend\\Source\\AST\\ASTVariableVariable',
            'PDepend\\Source\\AST\\ASTVariable',
        ];

        $this->assertGraphEquals($prefix, $expected);
    }

    /**
     * Tests that a parsed property postfix has the expected object structure.
     */
    public function testPropertyPostfixStructureForCompoundVariableAccess(): void
    {
        $prefix = $this->getFirstMemberPrimaryPrefixInFunction(__METHOD__);
        $expected = [
            'PDepend\\Source\\AST\\ASTVariable',
            'PDepend\\Source\\AST\\ASTPropertyPostfix',
            'PDepend\\Source\\AST\\ASTCompoundVariable',
            'PDepend\\Source\\AST\\ASTExpression',
            'PDepend\\Source\\AST\\ASTConstant',
            'PDepend\\Source\\AST\\ASTExpression',
            'PDepend\\Source\\AST\\ASTLiteral',
        ];

        $this->assertGraphEquals($prefix, $expected);
    }

    /**
     * Tests that a parsed property postfix has the expected object structure.
     */
    public function testPropertyPostfixStructureForCompoundExpressionAccess(): void
    {
        $prefix = $this->getFirstMemberPrimaryPrefixInFunction(__METHOD__);
        $expected = [
            'PDepend\\Source\\AST\\ASTVariable',
            'PDepend\\Source\\AST\\ASTPropertyPostfix',
            'PDepend\\Source\\AST\\ASTCompoundExpression',
            'PDepend\\Source\\AST\\ASTVariable',
        ];

        $this->assertGraphEquals($prefix, $expected);
    }

    /**
     * Tests that a parsed property postfix has the expected object structure.
     */
    public function testPropertyPostfixStructureForStaticVariableAccess(): void
    {
        $prefix = $this->getFirstMemberPrimaryPrefixInFunction(__METHOD__);
        $expected = [
            'PDepend\\Source\\AST\\ASTClassOrInterfaceReference',
            'PDepend\\Source\\AST\\ASTPropertyPostfix',
            'PDepend\\Source\\AST\\ASTVariable',
        ];

        $this->assertGraphEquals($prefix, $expected);
    }

    /**
     * Tests that a parsed method postfix has the expected object structure.
     */
    public function testPropertyPostfixStructureForStaticAccessOnVariable(): void
    {
        $prefix = $this->getFirstMemberPrimaryPrefixInFunction(__METHOD__);
        $expected = [
            'PDepend\\Source\\AST\\ASTVariable',
            'PDepend\\Source\\AST\\ASTPropertyPostfix',
            'PDepend\\Source\\AST\\ASTVariable',
        ];

        $this->assertGraphEquals($prefix, $expected);
    }

    /**
     * Tests that a parsed property postfix has the expected object structure.
     */
    public function testPropertyPostfixStructureForSelfVariableAccess(): void
    {
        $prefix = $this->getFirstMemberPrimaryPrefixInClass(__METHOD__);
        $expected = [
            'PDepend\\Source\\AST\\ASTSelfReference',
            'PDepend\\Source\\AST\\ASTPropertyPostfix',
            'PDepend\\Source\\AST\\ASTVariable',
        ];

        $this->assertGraphEquals($prefix, $expected);
    }

    /**
     * Tests that a parsed property postfix has the expected object structure.
     */
    public function testPropertyPostfixStructureForParentVariableAccess(): void
    {
        $prefix = $this->getFirstMemberPrimaryPrefixInClass(__METHOD__);
        $expected = [
            'PDepend\\Source\\AST\\ASTParentReference',
            'PDepend\\Source\\AST\\ASTPropertyPostfix',
            'PDepend\\Source\\AST\\ASTVariable',
        ];

        $this->assertGraphEquals($prefix, $expected);
    }

    /**
     * testPropertyPostfixGraphForObjectPropertyArrayIndexExpression
     *
     * <code>
     * $this->arguments[42] = func_get_args();
     * </code>
     */
    public function testPropertyPostfixGraphForObjectPropertyArrayIndexExpression(): void
    {
        $prefix = $this->getFirstMemberPrimaryPrefixInClass(__METHOD__);
        $expected = [
            'PDepend\\Source\\AST\\ASTVariable',
            'PDepend\\Source\\AST\\ASTPropertyPostfix',
            'PDepend\\Source\\AST\\ASTArrayIndexExpression',
            'PDepend\\Source\\AST\\ASTIdentifier',
            'PDepend\\Source\\AST\\ASTLiteral',
        ];

        $this->assertGraphEquals($prefix, $expected);
    }

    /**
     * testPropertyPostfixGraphForPropertyArrayIndexExpression
     *
     * <code>
     * self::$arguments[42] = func_get_args();
     * </code>
     */
    public function testPropertyPostfixGraphForStaticPropertyArrayIndexExpression(): void
    {
        $prefix = $this->getFirstMemberPrimaryPrefixInClass(__METHOD__);
        $expected = [
            'PDepend\\Source\\AST\\ASTSelfReference',
            'PDepend\\Source\\AST\\ASTPropertyPostfix',
            'PDepend\\Source\\AST\\ASTArrayIndexExpression',
            'PDepend\\Source\\AST\\ASTVariable',
            'PDepend\\Source\\AST\\ASTLiteral',
        ];

        $this->assertGraphEquals($prefix, $expected);
    }

    /**
     * Tests that a parsed property postfix has the expected object structure.
     */
    public function testPropertyPostfixSelfVariableInFunctionThrowsExpectedException(): void
    {
        $this->expectException(\PDepend\Source\Parser\InvalidStateException::class);

        $this->parseCodeResourceForTest();
    }

    /**
     * Tests that a parsed property postfix has the expected object structure.
     */
    public function testPropertyPostfixParentVariableInFunctionThrowsExpectedException(): void
    {
        $this->expectException(\PDepend\Source\Parser\InvalidStateException::class);

        $this->parseCodeResourceForTest();
    }

    /**
     * Tests that a parsed property postfix has the expected object structure.
     */
    public function testPropertyPostfixParentVariableInClassWithoutParentThrowsExpectedException(): void
    {
        $this->expectException(\PDepend\Source\Parser\InvalidStateException::class);

        $this->parseCodeResourceForTest();
    }

    /**
     * testPropertyPostfixHasExpectedStartLine
     */
    public function testPropertyPostfixHasExpectedStartLine(): void
    {
        $postfix = $this->getFirstPropertyPostfixInFunction(__METHOD__);
        $this->assertEquals(4, $postfix->getStartLine());
    }

    /**
     * testPropertyPostfixHasExpectedStartColumn
     */
    public function testPropertyPostfixHasExpectedStartColumn(): void
    {
        $postfix = $this->getFirstPropertyPostfixInFunction(__METHOD__);
        $this->assertEquals(21, $postfix->getStartColumn());
    }

    /**
     * testPropertyPostfixHasExpectedEndLine
     */
    public function testPropertyPostfixHasExpectedEndLine(): void
    {
        $postfix = $this->getFirstPropertyPostfixInFunction(__METHOD__);
        $this->assertEquals(4, $postfix->getEndLine());
    }

    /**
     * testPropertyPostfixHasExpectedEndColumn
     */
    public function testPropertyPostfixHasExpectedEndColumn(): void
    {
        $postfix = $this->getFirstPropertyPostfixInFunction(__METHOD__);
        $this->assertEquals(23, $postfix->getEndColumn());
    }

    /**
     * Creates a field declaration node.
     *
     * @return ASTPropertyPostfix
     */
    protected function createNodeInstance()
    {
        return new ASTPropertyPostfix(__CLASS__);
    }

    /**
     * Returns a node instance for the currently executed test case.
     *
     * @return ASTPropertyPostfix
     */
    private function getFirstPropertyPostfixInFunction()
    {
        return $this->getFirstNodeOfTypeInFunction(
            $this->getCallingTestMethod(),
            'PDepend\\Source\\AST\\ASTPropertyPostfix'
        );
    }

    /**
     * Returns a node instance for the currently executed test case.
     *
     * @param string $testCase Name of the calling test case.
     * @return ASTMemberPrimaryPrefix
     */
    private function getFirstMemberPrimaryPrefixInFunction($testCase)
    {
        return $this->getFirstNodeOfTypeInFunction(
            $testCase,
            'PDepend\\Source\\AST\\ASTMemberPrimaryPrefix'
        );
    }

    /**
     * Returns a node instance for the currently executed test case.
     *
     * @param string $testCase Name of the calling test case.
     * @return ASTMemberPrimaryPrefix
     */
    private function getFirstMemberPrimaryPrefixInClass($testCase)
    {
        return $this->getFirstNodeOfTypeInClass(
            $testCase,
            'PDepend\\Source\\AST\\ASTMemberPrimaryPrefix'
        );
    }
}
