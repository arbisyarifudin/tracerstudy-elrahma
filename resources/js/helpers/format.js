import moment from 'moment'
import 'moment/locale/id'
export default function useFormatHelper() {
  const formatDate = (dateString) => {
    console.log(moment.locale('id'))
    const momenDate = moment(new Date(dateString)).format(
      'DD MMMM YYYY HH:mm:ss'
    )
    return momenDate
  }

  return {
    formatDate
  }
}
