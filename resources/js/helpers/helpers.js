export function errors({data, status}) {
    if (status !== 422) return {}
    const errors = data.errors
    Object.keys(errors).forEach(key => {
        errors[key] = errors[key].join('<br>')
    })
    return errors
}

function fallbackCopyTextToClipboard(text, callback = null) {
    var textArea = document.createElement("textarea")
    textArea.value = text
    textArea.style.position = "fixed"  //avoid scrolling to bottom
    document.body.appendChild(textArea)
    textArea.focus()
    textArea.select()

    try {
        var successful = document.execCommand('copy')
        var msg = successful ? 'successful' : 'unsuccessful'
        callback()
    } catch (err) {
        console.error('Fallback: Oops, unable to copy', err)
    }

    document.body.removeChild(textArea)
}

export function copyTextToClipboard(text, callback = null) {
    if (!navigator.clipboard) {
        fallbackCopyTextToClipboard(text, callback)
        return
    }
    navigator.clipboard.writeText(text).then(function () {
        callback()
    }, function (err) {
        console.error('Async: Could not copy text: ', err)
    })
}
