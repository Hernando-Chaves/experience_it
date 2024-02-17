<div class="eits_container ">
    <h5>Filtrar por:</h5>
    <form action="" class="eits_form">
        <select name="filter_users" id="filter_users">
            <option value="">Selecciona un filtro</option>
            <option value="nombre">Nombre</option>
            <option value="apellido">Apellidos</option>
            <option value="apellido2">Apellido 1</option>
            <option value="correo">Correo</option>
        </select>
        <input type="text"  name="search_users" id="search_users" class="eits_input" placeholder="Escribe aquí el nombre o apellido según el filtro que escogiste">
        <input class="eits_btn" type="button" value="Buscar">
    </form>
    <div class="error_div hidden">Debes aplicar un filtro y escribir en el input lo que buscas</div>
    
    <div id="eits_table" class="hidden">
        <div class="result-table"></div>
        <div class="pagination">
            <div class="btn_page">1</div>
            <div class="btn_page">2</div>
            <div class="btn_page">3</div>
            <div class="btn_page">4</div>
        </div>
    </div>
    <div id="no_results">Selecciona un filtro para empezar la búsqueda</div>
</div>