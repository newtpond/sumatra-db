sp <- read.delim("table.txt", fileEncoding="UTF-8", header=TRUE)
spdf <- data.frame('species' = sp$Species, 'author' = sp$Author, 'acceptance' = sp$Acceptance, 'family' = sp$Family, 'island' = sp$Island, 'area' = sp$Area, 'origin' = sp$Origin, 'invasive_capacity' = sp$Invasive.capacity, 'plot' = sp$Plot, 'habitus' = sp$habitus, 'lifeform' = sp$life.form, 'collected' = sp$collected, 'photo' = sp$photo, 'fruit' = sp$Fruit.type, 'comments' = sp$comments)
jsn <- toJSON(spdf)
jsn