// output.pathに絶対パスを指定する必要があるため、pathモジュールを読み込んでおく
const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
  // モードの設定、v4系以降はmodeを指定しないと、webpack実行時に警告が出る
  mode: 'production',
  entry: './src/index.js',
  output: {
      filename: 'main.js',
      path: path.resolve(__dirname, 'dist'),
  },
  module: {
      rules: [
            {
                // 対象となるファイルの拡張子(scss)
                test: /\.scss$/,
                // sassファイルの読み込みとコンパイル
                use: [
                    // cssファイルを書き出すオプションを有効にする
                    {
                        loader: MiniCssExtractPlugin.loader,
                    },
                    // cssをバンドルするための機能
                    {
                        loader: "css-loader",
                        options: {
                            // オプションでcss内のurl()メソッドを取り込まない
                            url: false,
                            // ソースマップの利用有無
                            sourceMap: true,
                            // Sass + PostCssの場合は2を指定
                            importLoaders: 2,
                        },
                    },
                    // PostCssのための設定
                    {
                        loader: "postcss-loader",
                        options: {
                            //postcss側でもソースマップを有効
                            sourceMap: true,
                            postcssOptions: {
                                // ベンダープレフィックスを自動付与する
                                plugins: ["autoprefixer"],
                            },
                        },
                    },
                    // sassをバンドルするための機能
                    {
                        loader: "sass-loader",
                        options: {
                            // ソースマップの利用有無
                            sourceMap: true,
                        },
                    },
                ],
            },
        ],
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: "style.css",
        }),
    ],
    // source-map方式でないと、CSSの元ソースが追跡できないため
    devtool: "source-map",
};