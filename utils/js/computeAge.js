function computeAge(birthDate) {
    return ((d = new Date(birthDate)), n = new Date(), n.getFullYear() - d.getFullYear() - (n < new Date(n.getFullYear(), d.getMonth(), d.getDate())));
}
