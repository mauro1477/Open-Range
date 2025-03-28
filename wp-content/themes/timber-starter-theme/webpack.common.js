const { VueLoaderPlugin } = require("vue-loader");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const ImageMinimizerPlugin = require("image-minimizer-webpack-plugin");
const Webpack  = require('webpack');
const path = require('path');
const Dotenv = require('dotenv-webpack');

module.exports = {
  entry: {
      index: { import: '/assets/js/index.js'},
    },
  output: {
    path: path.resolve(__dirname, "dist"),
    filename: '[name].bundle.js',
  },
  module: {
    rules: [
      {
        test: /\.scss$/,
        use: [
            {
              loader: MiniCssExtractPlugin.loader,
            },
            {loader: 'css-loader', options:{ sourceMap:true }}, 
            {loader: 'postcss-loader', options:{ sourceMap:true }}, 
            {loader: 'sass-loader', options:{ sourceMap:true }},             
          ],
      },    
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: "babel-loader",
          options: {
            presets: [
              ['@babel/preset-env', { targets: "defaults" }]
            ]
          }
        },
      },
      {
        test: /\.vue$/,
        loader: "vue-loader"
      },
      {
        test: /\.(jpeg|png|gif|svg|jpg)$/i,
        type: "asset",

      },
      // We recommend using only for the "production" mode
      {
        test: /\.(jpe?g|png|gif|svg)$/i,
        enforce: "pre",
        generator: {
          filename: 'images/[name][ext]'
        },
        use: [
          {
            loader: ImageMinimizerPlugin.loader,
            options: {
              minimizer: {
                implementation: ImageMinimizerPlugin.imageminMinify,
                options: {
                  plugins: [
                    "imagemin-gifsicle",
                    "imagemin-mozjpeg",
                    "imagemin-pngquant",
                    "imagemin-svgo",
                  ],
                },
              },
            },
          },
        ],
      },
    ],
  },

  plugins: [
    new VueLoaderPlugin(),
    new MiniCssExtractPlugin({ 
      filename: '[name].bundle.css'
    }),

    new Webpack.DefinePlugin({
      __VUE_OPTIONS_API__: true,
      __VUE_PROD_DEVTOOLS__: false,
    }),
    new Dotenv({
      path: path.resolve(__dirname, `.env.${process.env.NODE_ENV || 'development'}`),
    })
  ],
  resolve: {
    extensions: [ '.tsx', '.ts', '.js', '.vue' , '.css'],
    alias: {
      'vue': path.join(__dirname, 'node_modules', 'vue', 'dist', 'vue.esm-browser.js'),
    }
  }
};