const { VueLoaderPlugin } = require("vue-loader");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const ImageMinimizerPlugin = require("image-minimizer-webpack-plugin");
const Webpack  = require('webpack');
const path = require('path');
const Dotenv = require('dotenv-webpack');
const TerserPlugin = require("terser-webpack-plugin");


const env_keys = function env_keys() {
  if (process.env.NODE_ENV === "production") {
    return ".env.production"
  } 
  else if(process.env.NODE_ENV === "staging"){
    return ".env.staging"
  }else{
    return ".env.development"
  }
}

module.exports = {
  entry: {
      //index = indexAppHomePage
      indexAppHomePage: { import: '/assets/js/indexAppHomePage.js'},
      indexAppSingleGuide: { import: '/assets/js/indexAppSingleGuide.js'},
      indexAppSinglePage: { import: '/assets/js/indexAppSinglePage.js'},
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
        loader: "vue-loader",
        options: {
          compilerOptions: {
            isCustomElement: tag => tag === 'script',
          },
        },
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
  optimization: {
    minimize: true, // Enable minimization
    minimizer: [
      new TerserPlugin({
        terserOptions: {
          // https://github.com/terser/terser#options
          // Example:
          compress: {
            drop_console: true, // Remove console.log statements
          },
        },
        extractComments: false, // Disable extracting comments to a separate file
      }),
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
      path: path.resolve(__dirname, env_keys()),
    })
  ],
  resolve: {
    extensions: [ '.tsx', '.ts', '.js', '.vue' , '.css'],
    alias: {
      'vue': path.join(__dirname, 'node_modules', 'vue', 'dist', 'vue.esm-browser.js'),
    }
  }
};