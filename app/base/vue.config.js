module.exports = {
  outputDir: '../docs',
  publicPath: process.env.NODE_ENV === 'production' ? '/app/' : '/',
  proxy: {
    '/api': {
      target: 'http://127.0.0.1:8000',
      changeOrigin: true,
      pathRewrite: {
        '^/api': '/'
      }
    }
  }
};
