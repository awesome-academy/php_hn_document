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
                ->assertSee(trans('M???i danh m???c'))
                ->assertSee(trans('Ti???ng Vi???t'))
                ->assertSee(trans('T???i l??n'))
                ->assertSee(trans('????ng k??'))
                ->assertSee(trans('????ng nh???p'))
                //body
                ->assertSee(trans('????ng k?? v???i'))
                ->assertSee(trans('Ho???c'))
                ->assertSee(trans('Email'))
                ->assertSee(trans('M???t kh???u'))
                ->assertSee(trans('T??n'))
                ->assertSee(trans('X??c nh???n m???t kh???u'))
                ->assertSee(trans('????ng k??'))
                ->assertSee(trans('B???n ???? c?? t??i kho???n?'))
                ->assertSee(trans('????ng nh???p'))
                //footer
                ->assertSee(trans('V??? ch??ng t??i'))
                ->assertSee(trans('Li??n k???t nhanh'))
                ->assertSee(trans('Li??n h???'))
                ->assertSee(trans('S???n s??ng ????? b???t ?????u?'));
        });
    }
}
