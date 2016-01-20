<?php
/**
 * Pterodactyl - Panel
 * Copyright (c) 2015 - 2016 Dane Everitt <dane@daneeveritt.com>
 * Some Modifications (c) 2015 Dylan Seidt <dylan.seidt@gmail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */
namespace Pterodactyl\Http\Routes;

use Illuminate\Routing\Router;

class BaseRoutes {

    public function map(Router $router) {

        // Index of Panel
        $router->get('/', [
            'as' => 'index',
            'middleware' => 'auth',
            'uses' => 'Base\IndexController@getIndex'
        ]);

        // Handle Index. Redirect /index to /
        $router->get('/index', function () {
            return redirect()->route('index');
        });

        // Password Generation
        $router->get('/password-gen/{length}', [
            'as' => 'password-gen',
            'middleware' => 'auth',
            'uses' => 'Base\IndexController@getPassword'
        ]);

        // Account Routes
        $router->group([
            'profix' => 'account',
            'middleware' => [
                'auth',
                'csrf'
            ]
        ], function () use ($router) {
            $router->get('account', [
                'as' => 'account',
                'uses' => 'Base\IndexController@getAccount'
            ]);
            $router->post('/account/password', [
                'uses' => 'Base\IndexController@postAccountPassword'
            ]);
            $router->post('/account/email', [
                'uses' => 'Base\IndexController@postAccountEmail'
            ]);
        });

        // TOTP Routes
        $router->group([
            'prefix' => 'account/totp',
            'middleware' => [
                'auth',
                'csrf'
            ]
        ], function () use ($router) {
            $router->get('/', [
                'as' => 'account.totp',
                'uses' => 'Base\IndexController@getAccountTotp'
            ]);
            $router->put('/', [
                'uses' => 'Base\IndexController@putAccountTotp'
            ]);
            $router->post('/', [
                'uses' => 'Base\IndexController@postAccountTotp'
            ]);
            $router->delete('/', [
                'uses' => 'Base\IndexController@deleteAccountTotp'
            ]);
        });

    }

}
