function calculateEvaluation(date_hired, months = 3) {
    if (!date_hired) return null;

    const date = new Date(date_hired);
    date.setMonth(date.getMonth() + months);

    return date.toISOString().split('T')[0];
}
