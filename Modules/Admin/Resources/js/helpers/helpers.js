export function errors({data, status}) {
    if (status !== 422) return {}
    const errors = data.errors
    Object.keys(errors).forEach(key => {
        errors[key] = errors[key].join('<br>')
    })
    return errors
}
