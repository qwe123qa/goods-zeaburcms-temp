/** @type {import('tailwindcss').Config} */
module.exports = {
	content: ['./*.php', './views/*.php', './src/*.js'],
	theme: {
		screens: {
			xl: { 'min': '1201px', 'max': '1700px' },
			lg: { 'max': '1200px' },
			md: { 'max': '900px' },
			sm: { 'max': '600px' },
			desktop: { 'min': '1200px' },
		},
		fontFamily: {
			'sans': ['Noto Sans TC', 'sans-serif'],
			'serif': ['Noto Serif SC', 'Noto Serif TC', 'serif'],
		},
		container: {
			center: true,
			screens: false,
		},
		extend: {
			colors: {
				gray: {
					DEFAULT: '#595757',
					400: '#b4b4b4',
				},
			},
			fontSize: {
				'xs': ['12px', '1.8'],
				'sm': ['14px', '1.8'],
				'base': ['16px', '1.8'],
				'lg': ['18px', '1.8'],
				'xl': ['20px', '1.8'],
				'2xl': ['30px', '1.2'],
				'3xl': ['40px', '1.2'],
				'4xl': ['66px', '1.1'],
				'5xl': ['86px', '1.1'],
				'6xl': ['108px', '1'],
			},
			letterSpacing: {
				'tighter': '-2px',
				'tight': '-1px',
				'none': '0px',
				'normal': '1px',
				'wide': '3px',
				'wider': '6px',
				'widest': '9px',
			},
			lineHeight: {
				'snug': '1.4',
				'normal': '1.6',
				'relaxed': '1.8',
				'loose': '2',
			},
			borderRadius: {
				sm: '7px',
				md: '14px',
				lg: '21px',
			},
			zIndex: {
				'60': '60',
				'70': '70',
				'80': '80',
				'90': '90',
			},
			transitionDelay: {
				'0': '0s',
			},
			animation: {
				'spin-slow': 'spin 10s linear infinite',
			},
			width: {
				'fill': '-webkit-fill-available',
			},
			height: {
				'fill': '-webkit-fill-available',
			},
		},
	},
	variants: {
		extend: {},
	},
	plugins: [],
};