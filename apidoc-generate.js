const path = require('path')
const apidoc = require('apidoc')

const doc = apidoc.createDoc({
    src: path.resolve(__dirname, 'Modules/Api/Http/Controllers'),
    dest: path.resolve(__dirname, 'public/apidoc')
})

if (typeof doc !== 'boolean') {
    console.log('Documentation has been generated!')
}
