import {Inertia} from '@inertiajs/inertia'
import {route} from '~/helpers/helpers'

export function useLogout() {
  const logout = () => Inertia.delete(route('logout'))
  return {logout}
}

export function formatDate(date) {
  const d = new Date(date)
  return `${d.getDate()} ${d.toLocaleDateString('en', {month: 'long'})}, ${d.getFullYear()}`
}
