function logout() {
    $('.logout').on('click', (e) => {
        e.preventDefault()
        $('#logout-form').submit()
    })
}

function menu() {
    if (Boolean(sessionStorage.getItem('sidebar-toggle-collapsed'))) {
        var body = document.getElementsByTagName('body')[0]
        body.className = body.className + ' sidebar-collapse'
    }
    $('*[data-widget="pushmenu"]').click(function (event) {
        event.preventDefault()
        if (Boolean(sessionStorage.getItem('sidebar-toggle-collapsed'))) {
            sessionStorage.setItem('sidebar-toggle-collapsed', '')
        } else {
            sessionStorage.setItem('sidebar-toggle-collapsed', '1')
        }
    })
}

$(() => {
    $("input[data-bootstrap-switch]").each(function () {
        $(this).bootstrapSwitch('state', $(this).prop('checked'))
    })

    logout()
    menu()
})
