const HELPER = {
    /**
     * Good to use in computed as a general method for filter
     * 
     * @param {what to filter for} filter 
     * @param {Array of data to filter} data 
     * @returns Returns the data filtered
     */
    getFiltered: function (filter, data) {
        if (filter.length) {
            return data.filter(
                (c) => c.label.toLowerCase().indexOf(filter) > -1
            );
        } else {
            return data;
        }
    }
}

export default HELPER