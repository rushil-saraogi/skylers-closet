module.exports = {
	root: true,

	parserOptions: {
		parser: 'babel-eslint',
		sourceType: 'module',
		ecmaVersion: 2017,
		allowImportExportEverywhere: true,
		codeFrame: true,
	},

	extends: [
		'plugin:vue/recommended',
		'plugin:jest/recommended',
		'airbnb-base',
	],

	settings: {
		'import/resolver': 'webpack',
	},

	rules: {
		// https://eslint.org/docs/user-guide/migrating-to-4.0.0#indent-rewrite
		indent: 'off',
		'indent-legacy': ['error', 'tab'],
		'no-tabs': 'off',
		'vue/html-indent': ['error', 'tab'],
		'object-curly-newline': 'off',
		'import/prefer-default-export': 'off',
		'max-len': 'off',
		'no-underscore-dangle': 'off',
		'prefer-destructuring': 'off',
		'no-console': ['warn', { allow: ['error'] }], // DEBT remove console.errors
		'no-param-reassign': 'off', // https://github.com/airbnb/javascript/issues/1217#issuecomment-286927523
		'func-names': ['error', 'as-needed'],
		'vue/no-v-html': 'off', // DEBT: Security concern with using `v-html`
		'vue/custom-event-name-casing': 'off', // Enable this after a fix for ":" is in place https://github.com/vuejs/eslint-plugin-vue/issues/1260
	},

	overrides: [{
		files: 'webpack.config.js',
		rules: {
			'import/no-extraneous-dependencies': 'off',
		},
	}],
};
