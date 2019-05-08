<?php

class Cita{
    var $paciente;
    var $fecha;
    var $enfermedad;
    var $mensaje;

    function Cita($paciente,$fecha,$enfermedad,$mensaje){
        $this->paciente = $paciente;
        $this->fecha = $fecha;
        $this->enfermedad = $enfermedad;
        $this->mensaje = $mensaje;
    }

    function getPaciente(){
        return $this->paciente;
    }

    function getFecha(){
        return $this->fecha;
    }

    function getEnfermedad(){
        return $this->enfermedad;
    }

    function getMensaje(){
        return $this->mensaje;
    }

    function crearCita(){
        
        // consultorio@consultorio-240013.iam.gserviceaccount.com GOOGLE SERVICE ACCOUNT
        
        $fechaFin = clone $this->fecha;
        $fechaFin->add(new DateInterval('PT1H')); //Añadir una hora a la fecha
        
        $CALENDAR_ID = '2jqh6lt8c742qctme1mb673djo@group.calendar.google.com';
        $service = $this->conectarCalendarAPI();
        $title = "Cita del paciente ".$this->paciente->getNombre();
        $description = "";
        $start = new Google_Service_Calendar_EventDateTime();
        $start->setDateTime($this->fecha->format(DateTime::RFC3339));
        $end = new Google_Service_Calendar_EventDateTime();
        $end->setDateTime($fechaFin->format(DateTime::RFC3339));

        echo 'email: '.$this->paciente->getEmail();
        
        $attendees = array(
            $this->crearAttendee(
                $this->paciente->getEmail(),
                $this->paciente->getNombre()
            )
        );
        
        
        echo $attendees[0]->getEmail();
        $event = $this->crearCalendarEvent($service, $CALENDAR_ID ,$title, $description, $start, $end, $attendees);
        //echo $event->getId();
    }

    function conectarCalendarAPI(){
        putenv('GOOGLE_APPLICATION_CREDENTIALS='.getcwd().'\consultorio-240013-93cd40aa22c8.json');
        $client = new Google_Client();
        $client->useApplicationDefaultCredentials();
        $client-> setScopes(Google_Service_Calendar::CALENDAR);
        $service = new Google_Service_Calendar($client);
        return $service;
    }

    function crearAttendee($email,$name){
        $attendee = new Google_Service_Calendar_EventAttendee();
        $attendee->setEmail($email);
        $attendee->setDisplayName($name);
        return $attendee;
    }

    function crearCalendarEvent($service,$calendarId,$title, $description, $start, $end, $attendees){
        $event = new Google_Service_Calendar_Event();
        $event->setSummary($title);
        $event->setDescription($description);
        $event->setStart($start);
        $event->setEnd($end);
        $event->setAttendees($attendees);
        return $service->events->insert($calendarId, $event, ['sendUpdates' => 'all']);
        //return $service->events->insert($calendarId, $event, ['sendUpdates' => 'all']);
        //sendUpdates send email invitation to costumer
    }

}

?>