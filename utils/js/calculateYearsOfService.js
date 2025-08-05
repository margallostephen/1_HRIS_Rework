function calculateYearsOfService(date_hired, current_status, last_date) {
    if (!date_hired) return null;

    const today = new Date();
    const todayStr = today.toISOString().slice(0, 10);
    if (date_hired >= todayStr) return '';

    const startDate = new Date(date_hired);
    if (isNaN(startDate)) return '';

    let endDate;
    if (current_status === 'PROBATIONARY' || current_status === 'REGULAR') {
        endDate = today;
    } else if (last_date) {
        endDate = new Date(last_date);
        if (isNaN(endDate)) return 'INVALID LAST DATE';
    } else {
        return 'PLEASE SPECIFY DATE OF SEPARATION';
    }

    let years = endDate.getFullYear() - startDate.getFullYear();
    let months = endDate.getMonth() - startDate.getMonth();
    let days = endDate.getDate() - startDate.getDate() + 1;

    if (months < 0 || (months === 0 && days < 1)) {
        years--;
        months += 12;
    }

    if (days < 0) {
        months--;
        const daysInPrevMonth = new Date(endDate.getFullYear(), endDate.getMonth(), 0).getDate();
        days = daysInPrevMonth - startDate.getDate() + endDate.getDate();
    }

    const formatPart = (value, singular, plural) =>
        value > 0 ? `${value} ${value === 1 ? singular : plural}` : '';

    const parts = [
        formatPart(years, 'YEAR', 'YEARS'),
        formatPart(months, 'MONTH', 'MONTHS'),
        formatPart(days, 'DAY', 'DAYS'),
    ].filter(Boolean);

    return parts.join(', ') || null;
}
