function formatAddress(addr) {
    const parts = [addr.street, addr.barangay, addr.municipality, addr.province, addr.zip];
    const filtered = parts.filter(v => v?.toString().trim());

    return filtered.length ? filtered.join(', ') : null;
}
