import React from 'react'
import { createInertiaApp } from '@inertiajs/react'
import { createRoot } from 'react-dom/client'

createInertiaApp({
    resolve: name => {
      const pages = import.meta.glob('./pages/**/*.jsx', { eager: true })
      return pages[`./pages/${name}.jsx`]
    },
    setup({ el, App, props }) {
      el.removeAttribute("data-page");
      createRoot(el).render(<App {...props} />)
    }, 
})