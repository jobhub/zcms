{% extends "../../../templates/frontend/default/index.volt" %}
{% block content %}
    {{ get_sidebar("sidebar_left") }}
    <a href="{{ loginUrl }}">Login with Facebook</a>
{% endblock %}