import { format } from 'date-fns';

export function formatDateTime(dateString) {
    const date = new Date(dateString);
    return format(date, 'HH:ii:ss dd-M-y');
}
export function formatDate(dateString) {
    const date = new Date(dateString);
    return format(date, 'dd-M-y');
}
