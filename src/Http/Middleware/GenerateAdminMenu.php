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
        $lang = lang();

        $menuAdmin = Menu::new()
                ->setActiveClass('active')
                ->setActiveClassOnLink()
                ->setAttribute('role', 'navigation')
                ->addClass('navbar-nav')
                ->wrap('div', ['class' => 'navigation-area'])
                ->prepend('<h6 class="navbar-heading text-muted">Navigation</h6>');
                $menuAdmin->add( Link::to( $multilang ? '/admin/dashboard?lang='.$lang : '/admin/dashboard', '<i class="ni ni-tv-2 text-primary"></i> '.__('admin.home.dashboard'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
                if($user->hasPermissionTo('create_posts')) {
                    $menuAdmin->add( Link::to( $multilang ? '/admin/posts?lang='.$lang : '/admin/posts', '<i class="ni ni-single-copy-04"></i> '.__('admin.posts.index'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
                    $menuAdmin->add( Link::to( $multilang ? '/admin/tags?lang='.$lang : '/admin/tags', '<i class="ni ni-single-copy-04"></i> '.__('admin.tags.index'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
                }
                if($user->hasPermissionTo('upload_media')) {
                    $menuAdmin->add( Link::to( $multilang ? '/admin/medias?lang='.$lang : '/admin/medias', '<i class="ni ni-image"></i> '.__('admin.medias.index'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
                }
                if($user->hasPermissionTo('create_categories')) {
                    $menuAdmin->add( Link::to( $multilang ? '/admin/categories?lang='.$lang : '/admin/categories', '<i class="ni ni-collection"></i> '.__('admin.categories.index'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
                }
                if($user->hasPermissionTo('create_pages')) {
                    $menuAdmin->add( Link::to( $multilang ? '/admin/pages?lang='.$lang : '/admin/pages', '<i class="ni ni-collection"></i> '.__('admin.pages.index'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
                }
                if($user->hasPermissionTo('create_menus')) {
                    $menuAdmin->add( Link::to( $multilang ? '/admin/menus?lang='.$lang : '/admin/menus', '<i class="ni ni-collection"></i> '.__('admin.menus.index'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
                }
                if($user->hasPermissionTo('manage_comments')) {
                    $menuAdmin->add( Link::to( $multilang ? '/admin/comments?lang='.$lang : '/admin/comments', '<i class="ni ni-collection"></i> '.__('admin.comments.index'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
                }
                if($user->hasPermissionTo('manage_settings')) {
                    $menuAdmin->add( Link::to( $multilang ? '/admin/settings?lang='.$lang : '/admin/settings', '<i class="ni ni-collection"></i> '.__('admin.settings.index'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
                }
                if($user->hasPermissionTo('create_users')) {
                    $menuAdmin->add( Link::to( $multilang ? '/admin/users?lang='.$lang : '/admin/users', '<i class="ni ni-circle-08"></i> '.__('admin.users.index'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
                }
                if($user->hasPermissionTo('create_translations')) {
                    $menuAdmin->add( Link::to( $multilang ? '/admin/traductions?lang='.$lang : '/admin/traductions', '<i class="ni ni-circle-08"></i> '.__('admin.traductions.index'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
                }
                if($user->hasPermissionTo('manage_mails')) {
                    $menuAdmin->add( Link::to( $multilang ? '/admin/mails?lang='.$lang : '/admin/mails', '<i class="ni ni-circle-08"></i> '.__('admin.mails.index'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
                    $menuAdmin->add( Link::to( $multilang ? '/admin/templates?lang='.$lang : '/admin/templates', '<i class="ni ni-single-copy-04"></i> '.__('admin.templates.index'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
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
