* Mapping an object array to a list of items:
    * In the example below, foods comes from a JSON object 'pet', which has a property 'foods' that is an array of string values:

        function(foods){
            return `
                <h4>Favorite foods</h4>
                <ul class="foods-list">
                    ${foods.map(food => `<li>${food}</li>`).join('')}
                </ul>
            `

    * The crucial line that iterates the array contains a 'map' method
        * With no 'join' method, the list would be comma separated
        * The long version of the 'map' line would look something like:

            ${foods.map(function(food){
                return `<li>${food}</li>
            }).join('')}

        * Because the 'map' uses only one line, you can dramatically shorten it!


