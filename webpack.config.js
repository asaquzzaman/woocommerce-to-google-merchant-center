const path = require('path');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin')
const shell = require('shelljs');
const outputPath = path.resolve( __dirname, 'assets/js/pro')
const plugins = [];
const isProduction = (process.env.NODE_ENV == 'production');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const OptimizeCSSPlugin = require('optimize-css-assets-webpack-plugin');

//Remove all webpack build file
shell.rm('-rf', outputPath)

function resolve (dir) {
  return path.join(__dirname, './assets/src', dir)
}

if (isProduction) {
    plugins.push(
        new UglifyJsPlugin()
    )   
}

// extract css into its own file
const extractCss = new ExtractTextPlugin({
    filename: "../css/woogool-style.css"
});

plugins.push( extractCss );

module.exports = {
    entry: {
        woogool_pro: './assets/src/start.js',
        library: './assets/src/helpers/library.js',
    },

    output: {
        path: outputPath,
        filename: '[name].js',
        publicPath: '',
        //chunkFilename: 'chunk/[chunkhash].chunk-bundle.js',
        //jsonpFunction: 'wedevsPmWebpack',
        // hotUpdateFunction: 'wedevsPmWebpacks',
    },

    resolve: {
        extensions: ['.js', '.vue', '.json'],
        alias: {
          '@components': resolve('components'),
          '@directives': resolve('directives'),
          '@helpers': resolve('helpers'),
          '@router': resolve('router'),
          '@store': resolve('store'),
          '@src': resolve('')
        }
    },

    module: {
        rules: [
            // doc url https://vue-loader.vuejs.org/en/options.html#loaders
            {   
                test: /\.vue$/,
                loader: 'vue-loader',
                options: {
                    loaders: {
                        js: 'babel-loader',
                    }
                },
            },
            {   
                test: /\.js$/,
                loader: 'babel-loader',
                include: [
                    resolve(''),
                    path.resolve('node_modules/vue-color'),
                    path.resolve('node_modules/vue-multiselect')
                ],
                query: {
                    presets:[ "env", "stage-3" , "es2015" ]
                }
             
            },
            {
                test: /\.(png|jpg|gif|svg)$/,
                loader: 'file-loader',
                exclude: /node_modules/,
                options: {
                    name: '[name].[ext]?[hash]',
                    outputPath: '../css/images/'
                }
            },
            {
                test: /\.less$/,
                use: extractCss.extract({
                    use: [
                        {
                            loader: "css-loader"
                        }, 
                        {
                            loader: "less-loader"
                        }
                    ]
                })
            },
            {
                test: /\.css$/,
                loader: "style-loader!css-loader"
            },
            {
                test: /\.(png|woff|woff2|eot|ttf|svg)$/,
                use: ['url-loader?limit=100000']
            }
        ]
    },
    plugins: plugins
}



