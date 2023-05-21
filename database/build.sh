cat database_creation.sql */* database_initial_data.sql > output.sql
sed -i '1,5d' output.sql