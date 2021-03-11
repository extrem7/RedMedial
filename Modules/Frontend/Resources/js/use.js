import {Inertia} from '@inertiajs/inertia'
import {route} from '~/helpers/helpers'

export function useLogout() {
  const logout = () => Inertia.delete(route('logout'))
  return {logout}
}
