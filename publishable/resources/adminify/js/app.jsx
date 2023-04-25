import React from 'react'
import { createInertiaApp } from '@inertiajs/react'
import { createRoot } from 'react-dom/client'
import AdminLayout from './layouts/AdminLayout';

createInertiaApp({
    resolve: (name) => {
      const pages = import.meta.glob('./pages/**/*.jsx', { eager: true })
      let page = pages[`./pages/${name}.jsx`].default;

      if(!page.layout){
        page.layout = (page) => { return <AdminLayout children={page} /> };
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