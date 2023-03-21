<?php

namespace Cursotopia\Entities;

class Enrollment {
    private ?int $id = null;
    private ?int $courseId = null;
    private ?int $studentId = null;
    private ?bool $isFinished = null;
    private ?string $enrollDate = null;
    private ?string $finishDate = null;
    private ?string $certificateUid = null;
    private ?float $amount = null;
    private ?int $paymentMethodId = null;
    private ?string $lastTimeChecked = null;
    private ?string $createdAt = null;
    private ?string $modifiedAt = null;
    private ?bool $active = null;

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of courseId
     */ 
    public function getCourseId()
    {
        return $this->courseId;
    }

    /**
     * Set the value of courseId
     *
     * @return  self
     */ 
    public function setCourseId($courseId)
    {
        $this->courseId = $courseId;

        return $this;
    }

    /**
     * Get the value of studentId
     */ 
    public function getStudentId()
    {
        return $this->studentId;
    }

    /**
     * Set the value of studentId
     *
     * @return  self
     */ 
    public function setStudentId($studentId)
    {
        $this->studentId = $studentId;

        return $this;
    }

    /**
     * Get the value of isFinished
     */ 
    public function getIsFinished()
    {
        return $this->isFinished;
    }

    /**
     * Set the value of isFinished
     *
     * @return  self
     */ 
    public function setIsFinished($isFinished)
    {
        $this->isFinished = $isFinished;

        return $this;
    }

    /**
     * Get the value of enrollDate
     */ 
    public function getEnrollDate()
    {
        return $this->enrollDate;
    }

    /**
     * Set the value of enrollDate
     *
     * @return  self
     */ 
    public function setEnrollDate($enrollDate)
    {
        $this->enrollDate = $enrollDate;

        return $this;
    }

    /**
     * Get the value of finishDate
     */ 
    public function getFinishDate()
    {
        return $this->finishDate;
    }

    /**
     * Set the value of finishDate
     *
     * @return  self
     */ 
    public function setFinishDate($finishDate)
    {
        $this->finishDate = $finishDate;

        return $this;
    }

    /**
     * Get the value of certificateUid
     */ 
    public function getCertificateUid()
    {
        return $this->certificateUid;
    }

    /**
     * Set the value of certificateUid
     *
     * @return  self
     */ 
    public function setCertificateUid($certificateUid)
    {
        $this->certificateUid = $certificateUid;

        return $this;
    }

    /**
     * Get the value of amount
     */ 
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set the value of amount
     *
     * @return  self
     */ 
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get the value of paymentMethodId
     */ 
    public function getPaymentMethodId()
    {
        return $this->paymentMethodId;
    }

    /**
     * Set the value of paymentMethodId
     *
     * @return  self
     */ 
    public function setPaymentMethodId($paymentMethodId)
    {
        $this->paymentMethodId = $paymentMethodId;

        return $this;
    }

    /**
     * Get the value of lastTimeChecked
     */ 
    public function getLastTimeChecked()
    {
        return $this->lastTimeChecked;
    }

    /**
     * Set the value of lastTimeChecked
     *
     * @return  self
     */ 
    public function setLastTimeChecked($lastTimeChecked)
    {
        $this->lastTimeChecked = $lastTimeChecked;

        return $this;
    }

    /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @return  self
     */ 
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of modifiedAt
     */ 
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * Set the value of modifiedAt
     *
     * @return  self
     */ 
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    /**
     * Get the value of active
     */ 
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set the value of active
     *
     * @return  self
     */ 
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }
}
