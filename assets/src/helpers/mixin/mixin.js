export default {
	methods: {

        httpRequest (property) {

            return jQuery.ajax(property);
        },

		/**
         * Get index from array object element
         *
         * @param   itemList
         * @param   id
         *
         * @return  int
         */
        getIndex  ( itemList, id, slug) {
            var index = false;

            jQuery.each(itemList, function(key, item) {
        
                if (item[slug] == id) {
                    index = key;
                }
            });

            return index;
        },
	}
}