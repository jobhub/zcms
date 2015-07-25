{% extends "../../../templates/frontend/default/index.volt" %}
{% block content %}
    <div class="container user-control">
        <div class="col-md-4 col-sm-4 col-md-offset-4 col-sm-offset-4">
            <div class="row">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ 'Login'|t }}</h3>
                    </div>
                    <div class="panel-body">
                        <form action="{{ _baseUri }}/user/login/" method="post">
                            <div class="form-group">
                                <label for="email">{{ 'Email'|t }}</label>
                                <input type="text" class="form-control" id="email" name="email" value="">
                            </div>
                            <div class="form-group">
                                <label for="password">{{ 'Password'|t }}</label>
                                <input type="password" class="form-control" id="password" name="password" value="">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-default" value="{{ 'Log in'|t }}">
                            </div>
                            <div class="form-group">
                                <a href="{{ _baseUri }}/user/register/">{{ 'Register an account' }}</a> | <a href="{{ _baseUri }}/user/forgot-password/">{{ 'Forgot your password?'|t }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
{% endblock %}