<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testViewRegisterInEnglish()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                //header
                ->assertSee(trans('home.categories'))
                ->assertSee(trans('home.en'))
                ->assertSee(trans('home.upload'))
                ->assertSee(trans('home.register'))
                ->assertSee(trans('home.sign_in'))
                // body
                ->assertSee(trans('authen.signup'))
                ->assertSee(trans('authen.or'))
                ->assertSee(trans('authen.email'))
                ->assertSee(trans('authen.name'))
                ->assertSee(trans('authen.password'))
                ->assertSee(trans('authen.confirm_password'))
                ->assertSee(trans('authen.register'))
                ->assertSee(trans('authen.question_register'))
                ->assertSee(trans('authen.login'))
                //footer
                ->assertSee(trans('home.ready'))
                ->assertSee(trans('home.about'))
                ->assertSee(trans('home.link'))
                ->assertSee(trans('home.contact'));
        });
    }

    public function testLinkLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->clickLink(trans('home.sign_in'))
                ->assertPathIs('/login');
        });
    }

    public function testLinkRegister()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->clickLink(trans('home.register'))
                ->assertPathIs('/register');
        });
    }

    public function testSubmitButtonRegister()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->press('form #button_register')
                ->assertPathIs('/register');
        });
    }

    public function testViewRegisterInVietnamese()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->clickLink(trans('home.en'))
                ->clickLink(trans('home.vi'))
                //header
                ->assertSee(trans('Mọi danh mục'))
                ->assertSee(trans('Tiếng Việt'))
                ->assertSee(trans('Tải lên'))
                ->assertSee(trans('Đăng kí'))
                ->assertSee(trans('Đăng nhập'))
                //body
                ->assertSee(trans('Đăng ký với'))
                ->assertSee(trans('Hoặc'))
                ->assertSee(trans('Email'))
                ->assertSee(trans('Mật khẩu'))
                ->assertSee(trans('Tên'))
                ->assertSee(trans('Xác nhận mật khẩu'))
                ->assertSee(trans('Đăng ký'))
                ->assertSee(trans('Bạn đã có tài khoản?'))
                ->assertSee(trans('Đăng nhập'))
                //footer
                ->assertSee(trans('Về chúng tôi'))
                ->assertSee(trans('Liên kết nhanh'))
                ->assertSee(trans('Liên hệ'))
                ->assertSee(trans('Sẵn sàng để bắt đầu?'));
        });
    }
}
