module.exports = {
  dev: {
    host: '192.168.1.181',
    // host: 'localhost',
    port: 4400, // local port for webpack-server
  },
  api: { // api proxy
    host: 'http://bbow.qiankaihua.top', // api host
    prefix: 'api'
  }
}
