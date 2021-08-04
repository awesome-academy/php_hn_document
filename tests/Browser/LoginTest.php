<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * @throws \Throwable
     */

    public function testLoginView()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                ->assertSee(config('web.logo'))
                ->assertSee(__('home.categories'))
                ->assertSee(__('home.en'))
                ->assertSee(__('home.register'))
                ->assertSee(__('home.sign_in'))
                ->assertSee(__('home.upload'))
                ->assertSee(__('home.ready'));
        });
    }

    public function testLoginViewInVietnamese()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                ->clickLink(__('home.vi'))
                ->assertSee(config('web.logo'))
                ->assertSee('Mọi danh mục')
                ->assertSee('Tiếng Việt')
                ->assertSee('Đăng kí')
                ->assertSee('Đăng nhập')
                ->assertSee('Tải lên')
                ->assertSee('Sẵn sàng để bắt đầu?');
        });
    }

    public function testCheckExistsElementOnView()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->assertPresent('.top_bar_menu')
                ->assertPresent('.logo')
                ->assertPresent('.header_search_input')
                ->assertPresent('.header_search_button')
                ->assertPresent('#form_login');
        });
    }

    public function testRegisterLinkSubmit()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                ->clickLink(__('home.register'))
                ->assertPathIs('/register');
        });
    }

    public function testLoginAction()
    {
        $user = User::find(11);
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', '12345678')
                ->press('Login')
                ->assertPathIs('/home');
        });
    }
}
