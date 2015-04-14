library('jsonlite')
sp <- read.delim("table.txt", fileEncoding="UTF-8", header=TRUE)
spdf <- data.frame('species' = sp$Species, 'author' = sp$Author, 'family' = sp$Family, 'habitat' = sp$Area, 'origin' = sp$Origin, 'invasive_capacity' = sp$Invasive.capacity, 'habit' = sp$habitus, 'lifeform' = sp$life.form, 'fruit_type' = sp$Fruit.type, 'comments' = sp$comments)
jsn <- toJSON(spdf)
jsn