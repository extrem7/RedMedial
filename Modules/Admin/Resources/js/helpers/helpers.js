export function errors({data, status}) {
    if (status !== 422) return {}
    return data.errors
}
