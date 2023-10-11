import React, {} from 'react'
import { createInertiaApp } from '@inertiajs/react'
import { createRoot } from 'react-dom/client'
import AdminLayout from './layouts/AdminLayout';
import AuthLayout from './layouts/AuthLayout';

createInertiaApp({
    resolve: (name) => {
      let names = JSON.parse(name); // aray of names
      const pages = import.meta.glob('./pages/**/*.jsx', { eager: true })
      let page = null;
      
      for (let index = 0; index < names.length; index++) {
        const element = names[index];
        
        if( pages[`./pages/${element}.jsx`] ) {
          page = pages[`./pages/${element}.jsx`].default;
          break;
        }
        
      }

      if( page ) {
        // console.log('Possibles Views', names, page);
      }

      if(!page) {
        throw new Error('page not resolved');
      }

      if(!page.layout && !names.includes('Auth') ){
        page.layout = (page) => <AdminLayout children={page} />
      }

      if(!page.layout && names.includes('Auth')){
        page.layout = (page) => <AuthLayout children={page} />
      }
      
      return page;
    },
    setup({ el, App, props }) {

     const setupRootElements = (el) => {
      el.classList.add('h-100');
      el.parentElement.classList.add('h-100');
      document.documentElement.classList.add('h-100');
      el.removeAttribute("data-page");
     }


     setupRootElements(el);
      
      createRoot(el).render(<App {...props} />)
    }, 
})