#!/bin/bash

# Install the CodeDeploy agent
sudo yum update -y
sudo yum install -y ruby wget

# Download the latest version of the CodeDeploy agent
cd /tmp
wget https://github.com/aws/aws-codedeploy-agent/releases/download/latest/codedeploy-agent-1.7.1-1.x86_64.rpm

# Install the CodeDeploy agent
sudo rpm -i codedeploy-agent-1.7.1-1.x86_64.rpm

# Start the CodeDeploy agent
sudo service codedeploy-agent start

# Enable the agent to start on boot
sudo systemctl enable codedeploy-agent

# Check the status of the agent
sudo service codedeploy-agent status
