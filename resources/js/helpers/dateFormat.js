import { format } from 'date-fns';

export function formatDate(dateString) {
    const date = new Date(dateString);
    return format(date, 'HH:ii:ss d-M-Y');
}
