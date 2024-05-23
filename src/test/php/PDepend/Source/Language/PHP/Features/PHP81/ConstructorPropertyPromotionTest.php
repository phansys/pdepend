<?php

/**
 * This file is part of PDepend.
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

namespace PDepend\Source\Language\PHP\Features\PHP81;

use PDepend\Source\AST\ASTFormalParameter;
use PDepend\Source\AST\ASTFormalParameters;
use PDepend\Source\Parser\TokenException;

/**
 * @covers \PDepend\Source\Language\PHP\AbstractPHPParser
 * @copyright 2008-2017 Manuel Pichler. All rights reserved.
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 * @group unittest
 * @group php8
 */
class ConstructorPropertyPromotionTest extends PHPParserVersion81TestCase
{
    public function testConstructorPropertyPromotion(): void
    {
        $method = $this->getFirstMethodForTestCase();
        $children = $method->getChildren();

        static::assertInstanceOf(ASTFormalParameters::class, $children[0]);

        /** @var ASTFormalParameters $parametersBag */
        $parametersBag = $children[0];

        /** @var ASTFormalParameter[] $parameters */
        $parameters = $parametersBag->getChildren();

        static::assertCount(4, $parameters);

        static::assertTrue($parameters[0]->isPromoted());
        static::assertFalse($parameters[0]->isPublic());
        static::assertFalse($parameters[0]->isProtected());
        static::assertTrue($parameters[0]->isPrivate());

        static::assertTrue($parameters[1]->isPromoted());
        static::assertFalse($parameters[1]->isPublic());
        static::assertTrue($parameters[1]->isProtected());
        static::assertFalse($parameters[1]->isPrivate());

        static::assertTrue($parameters[2]->isPromoted());
        static::assertTrue($parameters[2]->isPublic());
        static::assertFalse($parameters[2]->isProtected());
        static::assertFalse($parameters[2]->isPrivate());

        static::assertFalse($parameters[3]->isPromoted());
        static::assertFalse($parameters[3]->isPublic());
        static::assertFalse($parameters[3]->isProtected());
        static::assertFalse($parameters[3]->isPrivate());
    }

    public function testConstructorPropertyPromotionWithComments(): void
    {
        $method = $this->getFirstMethodForTestCase();
        $children = $method->getChildren();

        static::assertInstanceOf(ASTFormalParameters::class, $children[0]);

        /** @var ASTFormalParameters $parametersBag */
        $parametersBag = $children[0];

        /** @var ASTFormalParameter[] $parameters */
        $parameters = $parametersBag->getChildren();

        static::assertCount(4, $parameters);

        static::assertTrue($parameters[0]->isPromoted());
        static::assertFalse($parameters[0]->isPublic());
        static::assertFalse($parameters[0]->isProtected());
        static::assertTrue($parameters[0]->isPrivate());

        static::assertTrue($parameters[1]->isPromoted());
        static::assertFalse($parameters[1]->isPublic());
        static::assertTrue($parameters[1]->isProtected());
        static::assertFalse($parameters[1]->isPrivate());

        static::assertTrue($parameters[2]->isPromoted());
        static::assertTrue($parameters[2]->isPublic());
        static::assertFalse($parameters[2]->isProtected());
        static::assertFalse($parameters[2]->isPrivate());

        static::assertFalse($parameters[3]->isPromoted());
        static::assertFalse($parameters[3]->isPublic());
        static::assertFalse($parameters[3]->isProtected());
        static::assertFalse($parameters[3]->isPrivate());
    }

    public function testPropertyPromotionOnRandomMethod(): void
    {
        $this->expectException(TokenException::class);
        $this->expectExceptionMessage('Unexpected token: private, line: 5, col: 9');

        $this->parseCodeResourceForTest();
    }
}