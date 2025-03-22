const { VueLoaderPlugin } = require("vue-loader");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const Webpack  = require('webpack');
const path  = require('path');

module.exports = {
  mode: 'development',
  entry: {
    main: path.resolve(__dirname, '/assets/js/index.js'),
  },
  output: {
    path: path.resolve(__dirname, "dist"),
    filename: 'bundle.js'
  },
  module: {
    rules: [
            {
        test: /\.scss$/,
        use: [
            {
              loader: MiniCssExtractPlugin.loader,
            },
            'css-loader', 
            'postcss-loader', 
            'sass-loader'
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
        test: /\.(png|jpg|gif)$/i,
        use: [
          {
            loader: 'url-loader',
            options: {
              limit: 8192,
            },
          },
        ],
      },
    ],
  },
  plugins: [
    new VueLoaderPlugin(),
    new MiniCssExtractPlugin({ 
      filename: '[name].css'
    }),

    new Webpack.DefinePlugin({
      __VUE_OPTIONS_API__: true,
      __VUE_PROD_DEVTOOLS__: false,
    })
  ],
  resolve: {
    extensions: [ '.tsx', '.ts', '.js', '.vue' , '.css'],
    alias: {
      'vue': path.join(__dirname, 'node_modules', 'vue', 'dist', 'vue.esm-browser.js'),
    }
  }
};