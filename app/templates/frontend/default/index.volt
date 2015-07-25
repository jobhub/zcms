{% include "../../../templates/frontend/default/header.volt" %}
<!-- Main menu and slide Show -->
{% block sidebar_top %}
    <div class="container">
        {{ get_sidebar('sidebar_top') }}
    </div>
{% endblock %}
<!-- END Main menu and slide show -->
{% block content %}
{% endblock %}
{% include "../../../templates/frontend/default/footer.volt" %}