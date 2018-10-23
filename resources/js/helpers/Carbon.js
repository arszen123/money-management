export default class Carbon {
    static now() {
        this.__date = new Date();
        return this
    }

    static addDays(days) {
        this.__date.setDate(this.__date.getDate() + days)
        return this
    }

    static addMonths(months) {
        this.__date.setMonth(this.__date.getMonth() + months)
        return this
    }

    static addYears(years) {
        this.__date.setFullYear(this.__date.getFullYear() + years)
        return this
    }

    static format (format) {
        let date = this.__date
        return date.getFullYear() + '-' + (date.getMonth() >= 10 ? date.getMonth() : `0${date.getMonth()}`) + '-' + date.getDate();
    }
    static toString() {
        return this.format()
    }
}