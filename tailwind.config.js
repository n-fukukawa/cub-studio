const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: {
        content: [  './storage/framework/views/*.php', 
                    './resources/views/**/*.blade.php',
                    './resources/js/**/*.vue',
                 ],
        options: {
            safelist: ['bg-blue-dark', 'bg-pink', 'bg-gray-500'],
        }
    },

    theme: {
        letterSpacing: {
            tightest: '-.075em',
            tighter: '-.05em',
            tight: '-.025em',
            normal: '0',
            wide: '.025em',
            wider: '.05em',
            widest: '.1em',
            superwide: '.20em',
           },

        extend: {
            fontFamily: {
                sans: ['Roboto', "Noto Sans JP", ...defaultTheme.fontFamily.sans],
                logo: ['Cairo', ...defaultTheme.fontFamily.sans]
            },
            spacing: {
                '50vh': '50vh',
                '60vh': '60vh',
                '70vh': '70vh',
                '80vh': '80vh',
                '90vh': '90vh',
              },
            colors: {
                transparent: 'transparent',
                brown: {
                    DEFAULT: '#654210',
                },
                red: {
                    DEFAULT: '#8b342a',
                },
                pink: {
                    light: '#ca9da0',
                    DEFAULT: '#bd6d8f',
                    dark: '#b55a70',
                },
                blue: {
                    DEFAULT: '#9cb1c2',
                    dark: '#23466e',
                },
                green: {
                    light: '#acb130',
                    DEFAULT: '#71945a',
                    dark: '#556b2f',
                },
                orange: {
                    DEFAULT: '#e4aa01',
                }
              },
              placeholderOpacity: ['hover', 'active'],

            //   boxShadow: ['group-hover'],
        },

    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
