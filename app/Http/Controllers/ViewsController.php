<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewsController extends Controller
{
    public function conception()
    {
        return view ('categories.conception');
    }

    public function optimisation()
    {
        return view ('categories.optimisation');
    }

    public function referencement()
    {
        return view ('categories.referencement');
    }

    public function nousContacter()
    {
        return view ('fronts.nousContacter');
    }


    public function devisGratuis()
    {
        return view ('fronts.devisGratuis');
    }


    public function quiSommesNous()
    {
        return view ('fronts.quiSommesNous');
    }

    public function supports()
    {
        return view ('fronts.supports');
    }

    public function politiqueConfidentialite()
    {
        return view ('fronts.politiqueConfidentialite');
    }

    public function faqs()
    {
        return view ('fronts.faqs');
    }

    public function temoignages()
    {
        return view ('fronts.temoignages');
    }

    public function nosFormations()
    {
        return view ('fronts.nosFormations');
    }

    public function modeles()
    {
        return view ('fronts.modeles');
    }

    public function administration()
    {
        return view ('adminDashboard');
    }

    public function client()
    {
        return view ('dashboards.Client.homeClient');
    }

    public function redacteur()
    {
        return view ('dashboards.Etudiant.homeRedacteur');
    }

    public function etudiant()
    {
        return view ('dashboards.Redacteur.homeEtudiant');
    }

}
