import moment from 'moment'
import 'moment/dist/locale/id'
moment.locale('id')
export default function useFormatHelper() {
  const formatDate = (dateString, format = 'DD MMMM YYYY HH:mm:ss') => {
    console.log(moment.locale())
    const momenDate = moment(dateString).format(format)
    return momenDate
  }

  return {
    formatDate
  }
}
