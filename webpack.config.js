/**
 * All of the the JavaScript compile functionality
 * for Container Block plugin reside in this file.
 *
 * @requires    Webpack
 * @package     ifblock
 */
const path = require( 'path' );
const MiniCssExtractPlugin = require( 'mini-css-extract-plugin' );
const { CleanWebpackPlugin } = require( 'clean-webpack-plugin' );
const { BundleAnalyzerPlugin } = require( 'webpack-bundle-analyzer' );
const ProgressBarPlugin = require( 'progress-bar-webpack-plugin' );
const UglifyJsPlugin = require( 'uglifyjs-webpack-plugin' );
const DependencyExtractionWebpackPlugin = require( '@wordpress/dependency-extraction-webpack-plugin' );
const FixStyleOnlyEntriesPlugin = require( 'webpack-fix-style-only-entries' );
const WebpackRTLPlugin = require( 'webpack-rtl-plugin' );
const WebpackNotifierPlugin = require( 'webpack-notifier' );
const chalk = require( 'chalk' );
const NODE_ENV = process.env.NODE_ENV || 'development';

const editorConfig = {
	entry: {
		script: './assets/src/script.js',
	},
	output: {
		path: path.resolve( __dirname, './assets/dist/' ),
		filename: '[name].js',
		libraryTarget: 'this',
		// This fixes an issue with multiple webpack projects using chunking
		// See https://webpack.js.org/configuration/output/#outputjsonpfunction
		jsonpFunction: 'webpackIfBlockJsonp',
	},
	mode: NODE_ENV,
	performance: {
		hints: false,
	},
	stats: {
		all: false,
		assets: true,
		builtAt: true,
		colors: true,
		errors: true,
		hash: true,
		timings: true,
	},
	watchOptions: {
		ignored: /node_modules/,
	},
	devtool: NODE_ENV === 'development' ? 'source-map' : false,
	module: {
		rules: [
			{
				test: /\.jsx?$/,
				exclude: /node_modules/,
				use: {
					loader: 'babel-loader?cacheDirectory',
					options: {
						presets: [ '@wordpress/babel-preset-default' ],
						plugins: [
							[
								'@babel/plugin-proposal-object-rest-spread',
								{
									loose: true,
									useBuiltIns: true,
								},
							],
							[
								'@wordpress/babel-plugin-makepot',
								{
									output: 'languages/container-block-js.pot',
								},
							],
						],
					},
				},
			},
			{
				test: /\.css$/,
				use: [
					'style-loader',
					MiniCssExtractPlugin.loader,
					{
						loader: 'css-loader',
						options: {
							importLoaders: 1,
						},
					},
					{
						loader: 'postcss-loader',
						options: {
							plugins: [ require( 'autoprefixer' ) ],
						},
					},
				],
			},
		],
	},
	externals: {
		$: 'jquery',
		jQuery: 'jquery',
		'window.jQuery': 'jquery',
	},
	optimization: {
		minimizer: [
			new UglifyJsPlugin( {
				cache: true,
				parallel: true,
				uglifyOptions: {
					output: {
						ie8: false,
						comments: false,
					},
				},
			} ),
		],
	},
	plugins: [
		new CleanWebpackPlugin(),
		new BundleAnalyzerPlugin( {
			openAnalyzer: false,
		} ),
		new FixStyleOnlyEntriesPlugin(),
		new MiniCssExtractPlugin( {
			filename: 'style.css',
		} ),
		new WebpackRTLPlugin( {
			filename: 'style-rtl.css',
		} ),
		new ProgressBarPlugin( {
			format:
				chalk.blue( 'Build core script' ) +
				' [:bar] ' +
				chalk.green( ':percent' ) +
				' :msg (:elapsed seconds)',
		} ),
		new DependencyExtractionWebpackPlugin( {
			injectPolyfill: true,
		} ),
		new WebpackNotifierPlugin( {
			title: 'If Block',
			alwaysNotify: true,
			skipFirstNotification: true,
		} ),
	],
};

// Export the following module
module.exports = editorConfig;
