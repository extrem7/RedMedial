document.querySelectorAll('.has-treeview > .nav-link').forEach(el => {
    el.addEventListener('click', e => {
        e.preventDefault()
        e.currentTarget.parentNode.classList.toggle('menu-open')
    })
})
