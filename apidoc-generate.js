const path = require('path')
const apidoc = require('apidoc')

const doc = apidoc.createDoc({
    src: path.resolve(__dirname, 'Modules/Api/Http/Controllers'),
    dest: path.resolve(__dirname, 'public/apidoc')
})

if (typeof doc !== 'boolean') {
    // Documentation was generated!
    console.log(doc.data) // `api_data.json` file content
    console.log(doc.project) // `api_project.json` file content
}
