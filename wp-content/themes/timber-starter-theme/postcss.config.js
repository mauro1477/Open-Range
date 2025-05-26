if(process.env.NODE_ENV == "production"){
    module.exports = {
        plugins:{
            "@tailwindcss/postcss": {},
            autoprefixer: {},
            cssnano: {},
            'rucksack-css': {}
        }
    };
}else if (process.env.NODE_ENV == "staging"){
    module.exports = {
        plugins:{
            "@tailwindcss/postcss": {},
            autoprefixer: {},
            cssnano: {},
            'rucksack-css': {}
        }
    };
}else{
    module.exports = {
        plugins:{
            autoprefixer: {},
            'rucksack-css': {},
            "@tailwindcss/postcss": {},
        }
    };
}