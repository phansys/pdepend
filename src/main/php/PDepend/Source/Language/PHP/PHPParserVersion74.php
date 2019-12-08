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
 * @since 2.3
 */

namespace PDepend\Source\Language\PHP;

use PDepend\Source\AST\ASTFieldDeclaration;
use PDepend\Source\AST\ASTType;
use PDepend\Source\AST\ASTVariableDeclarator;
use PDepend\Source\Parser\UnexpectedTokenException;
use PDepend\Source\Tokenizer\Token;
use PDepend\Source\Tokenizer\Tokens;

/**
 * Concrete parser implementation that supports features up to PHP version 7.4.
 *
 * TODO: Check or implement features support for:
 * - Arrow functions
 *   https://www.php.net/manual/en/migration74.new-features.php#migration74.new-features.core.arrow-functions
 * - Limited return type covariance and argument type contravariance
 *   https://www.php.net/manual/en/migration74.new-features.php#migration74.new-features.core.type-variance
 * - Null coalescing assignment operator
 *   https://www.php.net/manual/en/migration74.new-features.php#migration74.new-features.core.null-coalescing-assignment-operator
 * - Unpacking inside arrays
 *   https://www.php.net/manual/en/migration74.new-features.php#migration74.new-features.core.unpack-inside-array
 * - Numeric literal separator
 *   https://www.php.net/manual/en/migration74.new-features.php#migration74.new-features.core.numeric-literal-separator
 *
 * @copyright 2008-2017 Manuel Pichler. All rights reserved.
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 * @since 2.4
 */
abstract class PHPParserVersion74 extends PHPParserVersion73
{
    protected function parseUnknownDeclaration($tokenType, $modifiers)
    {
        /**
         * Typed properties
         * https://www.php.net/manual/en/migration74.new-features.php#migration74.new-features.core.typed-properties
         */
        if ($tokenType == Tokens::T_STRING) {
            return $this->parseTypeHint();
        }

        return parent::parseUnknownDeclaration($tokenType, $modifiers);
    }

    protected function parseMethodOrFieldDeclaration($modifiers = 0)
    {
        $field = parent::parseMethodOrFieldDeclaration($modifiers);

        if ($field instanceof ASTType) {
            $type = $field;

            $field = parent::parseMethodOrFieldDeclaration($modifiers);

            if (!($field instanceof ASTFieldDeclaration)) {
                throw new UnexpectedTokenException($this->tokenizer->prevToken(), $this->tokenizer->getSourceFile());
            }

            $field->prependChild($type);
        }

        return $field;
    }
}
