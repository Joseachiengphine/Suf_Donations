// const colors = require('tailwindcss/colors')
//
// module.exports = {
//     content: [
//         './resources/**/*.blade.php',
//         './vendor/filament/**/*.blade.php',
//     ],
//     darkMode: 'class',
//     theme: {
//         extend: {
//             colors: {
//                 danger: colors.rose,
//                 primary: colors.blue,
//                 success: colors.green,
//                 warning: colors.yellow,
//             },
//         },
//     },
//     plugins: [
//         require('@tailwindcss/forms'),
//         require('@tailwindcss/typography'),
//     ],
// }

// const colors = require('tailwindcss/colors')
// const defaultTheme = require('tailwindcss/defaultTheme')

function withOpacityValue(variable) {
    return ({ opacityValue }) => {
        if (opacityValue === undefined) {
            return `rgb(var(${variable}))`
        }
        return `rgb(var(${variable}) / ${opacityValue})`
    }
}

const colors = require('tailwindcss/colors')
const defaultTheme = require('tailwindcss/defaultTheme')

const appColors = {
    info: {...colors.blue, DEFAULT: colors.blue["500"]},
    primary: {
        '50': '#f5f7fb',
        '100': '#ebeff7',
        '200': '#ced7eb',
        '300': '#b0bedf',
        '400': '#758ec6',
        '500': '#3A5DAE',
        '600': '#34549d',
        '700': '#2c4683',
        '800': '#233868',
        '900': '#1c2e55',
        DEFAULT: '#3A5DAE'
    },
    secondary: {...colors.slate, DEFAULT: colors.slate["500"]},
    accent: {
        '50': '#fcfaf6',
        '100': '#faf6ee',
        '200': '#f2e7d4',
        '300': '#ead9ba',
        '400': '#dbbd86',
        '500': '#CBA052',
        '600': '#b7904a',
        '700': '#98783e',
        '800': '#7a6031',
        '900': '#634e28',
        DEFAULT: '#CBA052'
    },
    warning: {...colors.amber, DEFAULT: colors.amber["500"]},
    danger: {
        DEFAULT: '#B42025',
        '50': '#F5C5C6',
        '100': '#F1AFB1',
        '200': '#E98487',
        '300': '#E1595D',
        '400': '#DA2D33',
        '500': '#B42025',
        '600': '#89181C',
        '700': '#5D1113',
        '800': '#32090A',
        '900': '#070101'
    },
    success: {
        ...colors.green,
        DEFAULT: colors.green["500"]
    },
};

module.exports = {
    content: [
        './resources/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            colors: appColors,
            fontFamily: {
                sans: ['DM Sans', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
};

