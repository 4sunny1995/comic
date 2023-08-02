// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'

import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
// import { mdi } from 'vuetify/iconsets/mdi'
import { aliases, mdi } from 'vuetify/iconsets/mdi-svg'
import { customTheme } from './theme.js'

export const vuetify = createVuetify({
  components,
  directives,
  icons: {
    defaultSet: 'mdi',
    aliases,
    sets: {
      mdi
    }
  },
  defaults: {
    global: {
      ripple: false
    },
    VSheet: {
      elevation: 4
    },
    VCard: {
      VBtn: {
        variant: 'outlined'
      },
      VTextField: {
        // hide-detail: 0
      }
    }
  },
  theme: {
    defaultTheme: 'customTheme',
    themes: {
      customTheme
    }
  }
})
