<?php 
$content = <<<TWIG
{% extends 'base.html.twig' %}

{% block title %}Joueur{% endblock %}

{% block body %}
<h1>{{ player.firstName }} {{ player.lastName }}</h1>
<p>Equipe : {{ player.team.name }}</p>
<p>Naissance : {{ player.birthDate|date('d/m/Y') }}</p>

<h2>Presences</h2>
<ul>
{% for presence in player.getPresences() %}
    <li>{{ presence.getEvent().getTitle() }} - {{ presence.date|date('d/m/Y') }} - {{ presence.status }}</li>
{% else %}
    <li>Aucune presence.</li>
{% endfor %}
</ul>

<a href="{{ path('player_list') }}">Retour a la liste</a>
{% endblock %}
TWIG;

file_put_contents('templates/player/show.html.twig', $content);
echo "OK !";