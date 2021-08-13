<?php

namespace Ludows\Adminify\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Menu\Laravel\Menu;
use Spatie\Menu\Laravel\Link;


class GenerateAdminMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function manageMenu() {
        $user = user();
        $multilang = config('site-settings.multilang');
        $menu_config = get_site_key('adminMenu');
        $lang = lang();

        $arrayDatas = array(
            'user' => $user,
            'multilang' => $multilang,
            'lang' => $lang
        );

        $menuAdmin = Menu::new()
                ->setActiveClass('active')
                ->setActiveClassOnLink()
                ->setAttribute('role', 'navigation')
                ->addClass('navbar-nav')
                ->wrap('div', ['class' => 'navigation-area'])
                ->prepend('<h6 class="navbar-heading text-muted">Navigation</h6>');
        $menuAdmin->add( Link::to( $multilang ? '/admin/dashboard?lang='.$lang : '/admin/dashboard', '<i class="ni ni-tv-2 text-primary"></i> '.__('admin.home.dashboard'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );

        foreach ($menu_config as $menu_str) {
            # code...
            $menu_class = app( get_site_key($menu_str) );

            if($menu_class->showInMenu) {
                $r = call_user_func_array( array($menu_class, 'getLinks'), array($menuAdmin, $arrayDatas) );
            }
        }
        if($user->hasRole('subscriber')) {
            $menuAdmin->add( Link::to($multilang ? '/admin/users'.'/'.$user->id. '/edit?lang='.$lang : '/admin/users'.'/'.$user->id. '/edit', '<i class="ni ni-circle-08"></i> '.__('admin.users.edit'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
        }
        
        return $menuAdmin;

    }
    public function handle(Request $request, Closure $next)
    {

        // dd($request->user()->hasPermissionTo('create_posts'));

        $menuAdmin = $this->manageMenu();
        
        view()->share('menuAdmin', $menuAdmin);

        return $next($request);
    }
}
